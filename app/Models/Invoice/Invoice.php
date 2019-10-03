<?php

namespace App\Models\Invoice;

use App\Models\RefEgais\ClientEgais;
use App\Department;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'doc_invoice';

    protected $fillable = ['date', 'number', 'barcode', 'incoming_number', 'incoming_date', 'sum',
        'quantity', 'quantity_pack',
        'doc_type', 'doc_id'];

    //region Reference
    //
    public function shipper(){
        return $this->belongsTo("App\Models\RefEgais\ClientEgais");
    }

    public function consignee(){
        return $this->hasOne("App\Models\RefEgais\ClientEgais", "id", "consignee_id");
    }

    public function invoiceLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceLine");
    }

    public function invoiceMarkLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceMarkLine");
    }

    public function invoicePackLines(){
        return $this->hasMany("App\Models\Invoice\InvoicePackLine");
    }

    public function invoicePalletLines(){
        return $this->hasMany("App\Models\Invoice\InvoicePalletLine");
    }

    public function invoiceReadLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceReadLine");
    }

    public function invoiceErrorLines(){
        return $this->hasMany("App\Models\Invoice\InvoiceErrorLine");
    }

    //endregion

    public static function add($fields)
    {
        $invoice = new static;
        $invoice->fill($fields);
        $invoice->setReference($fields);
        //$invoice->save();

        return $invoice;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->setReference($fields);
        $this->savedin1c = false;
        //$this->save();

        return $this;
    }

    public function remove()
    {
        $this->delete();
    }

    //region HeadSetters

    public function setShipper($id)
    {
        if($id == null) {return;}
        $this->shipper_id = $id;
        //$this->save();

        return $this;
    }

    public function setConsignee($id)
    {
        if($id == null) {return;}
        $this->consignee_id = $id;
        //$this->save();

        return $this;
    }

    public function setDepartment($id)
    {
        if($id == null) {return;}
        $this->department_id = $id;
        //$this->save();

        return $this;
    }

    public function SavedIn1c()
    {
        $this->savedin1c = true;
        $this->save();

        return $this;
    }

    public function setReference($fields)
    {
        if (array_key_exists('department_code', $fields)) {
            $department = Department::where('code', $fields['department_code'])->first();
            if ($department != null) {$this->setDepartment($department->id);}
        }

        if (array_key_exists('shipper_code', $fields)) {
            $clientEgais = ClientEgais::where('code', $fields['shipper_code'])->first();
            if ($clientEgais != null) {$this->setShipper($clientEgais->id);}
        }

        if (array_key_exists('consignee_code', $fields)) {
            $clientEgais = ClientEgais::where('code', $fields['consignee_code'])->first();
            if ($clientEgais != null) {$this->setConsignee($clientEgais->id);}
        }

        return $this;
    }

    //endregion

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

    public function deletePalletLines()
    {
        InvoicePalletLine::where('invoice_id', $this->id)->delete();
    }

    public function addLines($fields)
    {
        $line = new InvoiceLine();
        $line->fill($fields);
        $line->setReference($fields);
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

    public function addPalletLines($fields)
    {
        $line = new InvoicePalletLine();
        $line->fill($fields);
        $line->invoice_id = $this->id;
        $line->save();

        return $line;
    }


    private function findMarkLine($barcode, $packNumber = null)
    {
        $filter = [['invoice_id', '=', $this->id],
                   ['mark_code',  '=', $barcode]];

        if ($packNumber != null)
        {
            $filter[] = ['pack_number', '=', $packNumber];
        }

        $markLine = InvoiceMarkLine::where($filter)->first();

        return $markLine;
    }

    private function findPackLine($packNumber, $palletNumber = null)
    {
        $filter = [['invoice_id',  '=', $this->id],
                   ['pack_number', '=', $packNumber]];

        if ($palletNumber != null)
        {
            $filter[] = ['pallet_number', '=', $palletNumber];
        }

        $packLine = InvoicePackLine::where($filter)->first();

        return $packLine;
    }

    private function findPalletLine($palletNumber)
    {
        $palletLine = InvoicePalletLine::where( [['invoice_id', '=', $this->id],['pallet_number', '=', $palletNumber]] )->first();

        return $palletLine;
    }



    public function addBarCode($barcode, $palletId, $packId)
    {
        if (strlen($barcode) == 26 or strlen($barcode) == 18) {
            $palletLine = $this->findPalletLine($barcode);

            if ($palletLine != null)
            {
                $result = $this->addPalletStamp($palletLine);
            } else {
                $result = $this->addPackStamp($barcode, $palletId);
            }

            return $result;
        }

        $result = $this->addExciseStamp($barcode, $palletId, $packId);

        return $result;
    }

    private function addErrorLine($barcode, $errorMessage)
    {
        $invoiceErrorLine = new InvoiceErrorLine;
        $invoiceErrorLine->invoice_id = $this->id;
        $invoiceErrorLine->mark_code  = $barcode;
        $invoiceErrorLine->message    = $errorMessage;
        $invoiceErrorLine->save();

        return $invoiceErrorLine;
    }

    private function addExciseStamp($barcode, $palletId = null, $packId = null)
    {
        $result = ['error' => false,
                   'errorMessage' => '',
                   'packId' => $packId,
                   'palletId' => $palletId];

        //СКАНИРОВАНИЕ АКЦИЗНОЙ МАРКИ
        //101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI
        if (strlen($barcode) != 150 and strlen($barcode) != 68)
        {
            $errorMessage = "Не опознан ШК " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);

            $result['error']        = true;
            $result['errorMessage'] = $errorMessage;

            return $result;
        }


        $packLine = null;
        if ($packId != null) {
            $packLine = InvoicePackLine::find($packId);
            $packNumber = $packLine->pack_number;

            $markLine = $this->findMarkLine($barcode, $packNumber);
        } else {
            $markLine = $this->findMarkLine($barcode);
        }

        if ($markLine == null)
        {
            $errorMessage = "Не найдена марка в накладной " . $barcode;

            $this->addErrorLine($barcode, $errorMessage);

            $result['error']        = true;
            $result['errorMessage'] = $errorMessage;

            return $result;
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
            /*
            $invoiceReadLine = new InvoiceReadLine;
            $invoiceReadLine->invoice_id      = $this->id;
            $invoiceReadLine->line_id         = $markLine->line_id;
            $invoiceReadLine->line_identifier = $markLine->line_identifier;
            $invoiceReadLine->mark_code       = $barcode;
            $invoiceReadLine->savedin1c       = false;
            $invoiceReadLine->save();
            */

            /*
            if (!$markLine->read)
            {
                $markLine->read = true;
                $markLine->save();
            };

            if ($packId != null and !$packLine->read)
            {
                $packLine->read = true;
                $packLine->save();
            };

            if ($palletId != null)
            {
                $palletLineFirst = InvoicePalletLine::find($palletId);
                $palletLine = InvoicePalletLine::where( [['invoice_id', '=', $this->id],
                                                         ['line_identifier', '=', $markLine->line_identifier],
                                                         ['pallet_number', '=', $palletLineFirst->pallet_number]])->first();

                if (!$palletLine->read)
                {
                    $palletLine->read = true;
                    $palletLine->save();
                }
            }
            */

            $invoiceLine = InvoiceLine::where( [['invoice_id', '=', $this->id],['line_identifier', '=', $markLine->line_identifier]] )->first();
            if ($invoiceLine != null)
            {
                if (!$markLine->read)
                {
                    $markLine->read = true;
                    $markLine->save();

                    $invoiceLine->increment('quantity_mark');
                };

                if ($packId != null and !$packLine->read)
                {
                    $packLine->read = true;
                    $packLine->save();

                    $invoiceLine->increment('quantity_pack_mark');
                };

                if ($palletId != null)
                {
                    $palletLineFirst = InvoicePalletLine::find($palletId);
                    $palletLine = InvoicePalletLine::where( [['invoice_id', '=', $this->id],
                        ['line_identifier', '=', $markLine->line_identifier],
                        ['pallet_number', '=', $palletLineFirst->pallet_number]])->first();

                    if (!$palletLine->read)
                    {
                        $palletLine->read = true;
                        $palletLine->save();

                        $invoiceLine->increment('quantity_pallet_mark');
                    }
                }


                //$invoiceLine->increment('quantity_mark');
                $invoiceLine->show_first = true;

                /*
                if ($packId != null and $invoiceLine->quantity_pack_mark == 0){
                    $invoiceLine->increment('quantity_pack_mark');
                }

                if ($palletId != null and $invoiceLine->quantity_pallet_mark == 0){
                    $invoiceLine->increment('quantity_pallet_mark');
                }
                */

                $invoiceLine->save();
            }

            DB::commit();

        } catch(\Exception $exception){

            $result['error']        = true;
            $result['errorMessage'] = "Ошибка при записи " . $barcode;

            DB::rollback();
        }

        return $result;
    }

    private function addPackStamp($packNumber, $palletId = null)
    {
        $result = ['error' => false,
                   'errorMessage' => '',
                   'packId' => null,
                   'palletId' => $palletId];

        if ($palletId != null) {
            $palletLine = InvoicePalletLine::find($palletId);
            $palletNumber = $palletLine->pallet_number;

            $packLine = $this->findPackLine($packNumber, $palletNumber);
        } else {
            $packLine = $this->findPackLine($packNumber);
        }

        if ($packLine == null)
        {
            $errorMessage = "Не найден ШК упаковки " . $packNumber;

            $this->addErrorLine($packNumber, $errorMessage);

            $result['error']        = true;
            $result['errorMessage'] = $errorMessage;

            return $result;
        }

        $result['packId'] = $packLine->id;

        return $result;
    }

    private function addPalletStamp($PalletLine)
    {
        $result = ['error' => false,
                   'errorMessage' => '',
                   'packId' => null,
                   'palletId' => $PalletLine->id];

        return $result;
    }

}
