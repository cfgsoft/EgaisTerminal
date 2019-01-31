<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

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

}
