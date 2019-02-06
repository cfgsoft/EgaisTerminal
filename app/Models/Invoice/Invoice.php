<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'doc_invoice';

    protected $fillable = ['date', 'number', 'barcode', 'incoming_number', 'incoming_date', 'sum',
        'quantity', 'quantity_pack',
        'doc_type', 'doc_id'];

    public function invoiceLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceLine");
    }

    public function invoiceMarkLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceMarkLine");
    }

    public function invoicePackLines(){
        return $this->hasMany("App\Models\Invoice\InvoicePackLine");
    }

    public function invoiceReadLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceReadLine");
    }

    public function invoiceErrorLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceErrorLine");
    }


    public static function add($fields)
    {
        $invoice = new static;
        $invoice->fill($fields);
        //$invoice->save();

        return $invoice;
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

    public function setShipper($id)
    {
        if($id == null) {return;}
        $this->shipper_id = $id;
        $this->save();
    }

    public function setConsignee($id)
    {
        if($id == null) {return;}
        $this->consignee_id = $id;
        $this->save();
    }


    public function deleteLines()
    {
        InvoiceLine::where('invoice_id', $this->id)->delete();
    }

    public function deleteMarkLines()
    {
        InvoiceMarkLine::where('invoice_id', $this->id)->delete();
    }

    public function deletePackLines()
    {
        InvoicePackLine::where('invoice_id', $this->id)->delete();
    }

    public function addLines($fields)
    {
        $line = new InvoiceLine();
        $line->fill($fields);
        $line->invoice_id = $this->id;
        $line->save();

        return $line;
    }

    public function addMarkLines($fields)
    {
        $line = new InvoiceMarkLine();
        $line->fill($fields);
        $line->invoice_id = $this->id;
        $line->save();

        return $line;
    }

    public function addPackLines($fields)
    {
        $line = new InvoicePackLine();
        $line->fill($fields);
        $line->invoice_id = $this->id;
        $line->save();

        return $line;
    }


    public function addBarCode($barcode)
    {
        if (strlen($barcode) == 26) {
            $result = $this->addPackStamp($barcode);
        } else {
            $result = $this->addExciseStamp($barcode);
        }

        return $result;
    }

    private function addErrorLine($barcode, $errorMessage)
    {
        $invoiceErrorLine = new InvoiceErrorLine;
        $invoiceErrorLine->invoice_id = $this->id;
        $invoiceErrorLine->mark_code = $barcode;
        $invoiceErrorLine->message = $errorMessage;
        $invoiceErrorLine->save();

        return $invoiceErrorLine;
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

        $invoiceMarkLine = InvoiceMarkLine::where( [['invoice_id', '=', $this->id],['mark_code', '=', $barcode]] )->first();
        if ($invoiceMarkLine == null)
        {
            $errorMessage = "Не найдена марка в накладной " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
        $invoiceReadLine = InvoiceReadLine::where( [['invoice_id', '=', $this->id],['mark_code', '=', $barcode]] )->first();
        if ($invoiceReadLine != null)
        {
            $errorMessage = "Товар уже сканировался " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //Обнуление showFirst  у заказа
        $this->invoiceLines->each(function ($item, $key) {
            if ($item->show_first) {
                $item->show_first = false;
                $item->save();
            }
        });

        DB::beginTransaction();

        try{
            $invoiceReadLine = new InvoiceReadLine;
            $invoiceReadLine->invoice_id      = $this->id;
            $invoiceReadLine->line_id         = $invoiceMarkLine->line_id;
            $invoiceReadLine->line_identifier = $invoiceMarkLine->line_identifier;
            $invoiceReadLine->mark_code       = $barcode;
            $invoiceReadLine->savedin1c       = false;
            $invoiceReadLine->save();

            $invoiceLine = InvoiceLine::where( [['invoice_id', '=', $this->id],['line_identifier', '=', $invoiceMarkLine->line_identifier]] )->first();
            if ($invoiceLine != null)
            {
                //$invoiceLine->quantity_mark = $invoiceLine->quantity_mark + 1;
                $invoiceLine->increment('quantity_mark');
                $invoiceLine->show_first = true;
                $invoiceLine->save();
            }

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

    private function addPackStamp($barcode)
    {
        $errorBarCode = false;
        $errorMessage = "";

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) != 26)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        $invoicePackLine = InvoicePackLine::where( [['invoice_id', '=', $this->id],['mark_code', '=', $barcode]] )->first();
        if ($invoicePackLine == null)
        {
            $errorMessage = "Не найден ШК упаковки в накладной " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //1. Ищем штрих код в уже набранных товарах, если находим ошибка.
        $invoiceReadLine = InvoiceReadLine::where( [['invoice_id', '=', $this->id],['mark_code', '=', $barcode]] )->first();
        if ($invoiceReadLine != null)
        {
            $errorMessage = "Упаковка уже сканировалась " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);
            return ['error' => true, 'errorMessage' => $errorMessage ];
        }

        //Обнуление showFirst  у заказа
        $this->invoiceLines->each(function ($item, $key) {
            if ($item->show_first) {
                $item->show_first = false;
                $item->save();
            }
        });

        DB::beginTransaction();

        try{
            $invoiceReadLine = new InvoiceReadLine;
            $invoiceReadLine->invoice_id      = $this->id;
            $invoiceReadLine->line_id         = $invoicePackLine->line_id;
            $invoiceReadLine->line_identifier = $invoicePackLine->line_identifier;
            $invoiceReadLine->mark_code       = $barcode;
            $invoiceReadLine->savedin1c       = false;
            $invoiceReadLine->save();

            $invoiceLine = InvoiceLine::where( [['invoice_id', '=', $this->id],['line_identifier', '=', $invoicePackLine->line_identifier]] )->first();
            if ($invoiceLine != null)
            {
                $invoiceLine->increment('quantity_mark');
                $invoiceLine->show_first = true;
                $invoiceLine->save();
            }

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
}
