<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceMarkLine extends Model
{
    protected $table = 'doc_invoice_mark_line';

    protected $fillable = ['line_id', 'line_identifier', 'mark_code'];

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }

    public static function add($fields, Invoice $invoice)
    {
        $invoiceMarkLine = new static;
        $invoiceMarkLine->fill($fields);
        $invoiceMarkLine->invoice_id = $invoice->id;
        $invoiceMarkLine->save();

        return $invoice;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();

        return $this;
    }

    public function remove()
    {
        $this->delete();
    }
}
