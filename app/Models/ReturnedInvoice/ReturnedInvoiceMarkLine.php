<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoiceMarkLine extends Model
{
    protected $table = 'doc_returned_invoice_mark_line';

    protected $fillable = ['lineid', 'productdescr', 'productcode', 'f2regid',
        'markcode', 'quantity', 'savedin1c', 'returned_invoice_id'];

    public function returnedInvoice(){
        return $this->belongsTo("App\Models\ReturnedInvoice\ReturnedInvoice");
    }
}
