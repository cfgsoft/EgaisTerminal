<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\ExciseStamp;
use App\ExciseStampBox;
use App\Models\ReturnedInvoice\ReturnedInvoicePackLine;

class ReturnedInvoice extends Model
{
    protected $table = 'doc_returned_invoice';

    protected $fillable = ['date', 'number', 'barcode', 'status',
        'quantity', 'quantity_marks', 'doc_type', 'doc_id'];

    public function returnedInvoiceLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceLine");
    }

    public function returnedInvoiceMarkLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceMarkLine");
    }

    public function returnedInvoicePackLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoicePackLine");
    }

    public function returnedInvoiceErrorLines(){
        return $this->hasMany("App\Models\ReturnedInvoice\ReturnedInvoiceErrorLine");
    }

    public static function add($fields)
    {
        $returnedInvoice = new static;
        $returnedInvoice->fill($fields);
        //$returnedInvoice->save();

        return $returnedInvoice;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        //$this->save();

        return $this;
    }

    public function remove()
    {
        $this->delete();
    }

    public function addBarCode($barcode)
    {
        if (strlen($barcode) == 26) {
            $result = $this->addPackExciseStamp($barcode);
        } else {
            $result = $this->addExciseStamp($barcode);
        }

        return $result;
    }

    private function addErrorLine($barcode, $errorMessage)
    {
        $returnedInvoiceErrorLine = new ReturnedInvoiceErrorLine;
        $returnedInvoiceErrorLine->returned_invoice_id = $this->id;
        $returnedInvoiceErrorLine->markcode = $barcode;
        $returnedInvoiceErrorLine->message = $errorMessage;
        $returnedInvoiceErrorLine->save();

        return $returnedInvoiceErrorLine;
    }

    private function addExciseStamp($barcode)
    {
        $errorBarCode = false;
        $errorMessage = "";

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) != 150 and strlen($barcode) != 68)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        $exciseStamp = ExciseStamp::find($barcode);
        if ($exciseStamp == null)
        {
            $errorMessage = "Не найдена марка в БД " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
        //$returnedInvoiceMarkLine = ReturnedInvoiceMarkLine::where([['markcode', '=', $barcode],['quantity', '=', '1']])->first();
        //if ($returnedInvoiceMarkLine != null)
        //{
        //    $errorMessage = "Товар уже сканировался " . $barcode;
        //
        //    $this->addErrorLine($barcode, $errorMessage);
        //    return ['error' => true, 'errorMessage' => $errorMessage ];
        //}

        //2. Ищем товар в строке заказов
        //Временно ищем без привязки в разделуБ
        //["f2regid",             "=", $exciseStamp->f2regid]
        //["productcode",         "=", $exciseStamp->productcode]
        $returnedInvoiceLine = ReturnedInvoiceLine::where([
            ["returned_invoice_id", "=", $this->id],
            ["f2regid",             "=", $exciseStamp->f2regid]
        ])->first();

        if ($returnedInvoiceLine == null)
        {
            $errorMessage = "Раздел Б " . $exciseStamp->f2regid . " не зайден в заказе " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        if ($returnedInvoiceLine->quantity <= $returnedInvoiceLine->quantitymarks )
        {
            $errorMessage = "Превышено количество в наборе " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }


        //Обнуление showFirst  у заказа
        $this->returnedInvoiceLines->each(function ($item, $key) {
            if ($item->show_first) {
                $item->show_first = false;
                $item->save();
            }
        });

        DB::beginTransaction();

        try{
            $returnedInvoiceMarkLine = new ReturnedInvoiceMarkLine;
            $returnedInvoiceMarkLine->returned_invoice_id  = $this->id;
            $returnedInvoiceMarkLine->lineid               = $returnedInvoiceLine->lineid;
            $returnedInvoiceMarkLine->f2regid     = $exciseStamp->f2regid;
            $returnedInvoiceMarkLine->markcode    = $barcode;
            //$returnedInvoiceMarkLine->boxnumber   = "000000000000000000000";
            $returnedInvoiceMarkLine->quantity    = 1;
            $returnedInvoiceMarkLine->savedin1c   = false;
            $returnedInvoiceMarkLine->save();

            //$returnedInvoiceLine->quantity_mark = $returnedInvoiceLine->quantity_mark + 1;
            $returnedInvoiceLine->increment('quantity_mark');
            $returnedInvoiceLine->show_first = true;
            $returnedInvoiceLine->save();

            DB::commit();

        } catch(\Exception $exception){
            $errorBarCode = true;
            $errorMessage = "Ошибка при записи " . $barcode;

            DB::rollback();
        }

        if ($errorBarCode && strlen($barcode) > 0) {
            $this->addErrorLine($barcode, $errorMessage);

            return ['error' => $errorBarCode, 'errorMessage' => $errorMessage ];
        }

        return ['error' => false, 'errorMessage' => ''];
    }

    private function addPackExciseStamp($barcode)
    {
        //СКАНИРОВАНИЕ ЯЩИКА
        if (strlen($barcode) != 26) {
            $errorMessage = "Не опознан ШК ящика " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1.
        $exciseStampBox = ExciseStampBox::where('barcode', '=', $barcode)->first();
        if ($exciseStampBox == null) {
            $errorMessage = "Не опознан ШК ящика " . $barcode;

            $this->addErrorLine($barcode, '', '', $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //2.
        $returnedInvoicePackLine = ReturnedInvoicePackLine::where([
            ["returned_invoice_id", "=", $this->id],
            ["markcode",            "=", $barcode]
        ])->first();

        if ($returnedInvoicePackLine != null)
        {
            $errorMessage = "Ящик уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //Обнуление showFirst  у заказа
        $this->returnedInvoiceLines->each(function ($item, $key) {
            if ($item->show_first) {
                $item->show_first = false;
                $item->save();
            }
        });

        DB::beginTransaction();

        $linesBox = $exciseStampBox->excisestampboxlines;
        foreach ($linesBox as $line)
        {
            $exciseStamp = ExciseStamp::find($line->markcode);
            if ($exciseStamp == null)
            {
                $errorMessage = "Не найдена марка в БД " . $barcode;

                DB::rollBack();

                $this->addErrorLine($line->id, $errorMessage);
                return ['error' => true, 'errorMessage' => $errorMessage ];
            }

            $returnedInvoiceLine = ReturnedInvoiceLine::where([
                ["returned_invoice_id", "=", $this->id],
                ["f2regid",             "=", $exciseStamp->f2regid]
            ])->first();

            if ($returnedInvoiceLine == null)
            {
                $errorMessage = "Раздел Б " . $exciseStamp->f2regid . " не зайден в возврате " . $barcode;

                DB::rollBack();

                $this->addErrorLine($barcode, $errorMessage);
                return ['error' => true, 'errorMessage' => $errorMessage ];
            }

            if ($returnedInvoiceLine->quantity <= $returnedInvoiceLine->quantitymarks )
            {
                $errorMessage = "Превышено количество в наборе " . $barcode;

                DB::rollBack();

                $this->addErrorLine($barcode, $errorMessage);
                return ['error' => true, 'errorMessage' => $errorMessage ];
            }

            try{
                $returnedInvoiceMarkLine = new ReturnedInvoiceMarkLine;
                $returnedInvoiceMarkLine->returned_invoice_id  = $this->id;
                $returnedInvoiceMarkLine->lineid               = $returnedInvoiceLine->lineid;
                $returnedInvoiceMarkLine->f2regid     = $exciseStamp->f2regid;
                $returnedInvoiceMarkLine->markcode    = $line->markcode;
                $returnedInvoiceMarkLine->pack_number = $exciseStampBox->barcode;
                $returnedInvoiceMarkLine->quantity    = 1;
                $returnedInvoiceMarkLine->savedin1c   = false;
                $returnedInvoiceMarkLine->save();

                $returnedInvoiceLine->increment('quantity_mark');
                $returnedInvoiceLine->show_first = true;
                $returnedInvoiceLine->save();

            } catch(\Exception $exception){
                $errorMessage = "Ошибка при записи " . $barcode;

                DB::rollback();

                return ['error' => true, 'errorMessage' => $errorMessage ];
            }

        }

        $returnedInvoicePackLine = new ReturnedInvoicePackLine;
        $returnedInvoicePackLine->returned_invoice_id = $this->id;
        $returnedInvoicePackLine->lineid        = 1;
        $returnedInvoicePackLine->f2regid       = $exciseStampBox->f2regid;
        $returnedInvoicePackLine->markcode      = $exciseStampBox->barcode;
        $returnedInvoicePackLine->quantity      = 1;
        $returnedInvoicePackLine->savedin1c     = false;
        $returnedInvoicePackLine->save();

        DB::commit();

        return ['error' => false, 'errorMessage' => ''];
    }
}
