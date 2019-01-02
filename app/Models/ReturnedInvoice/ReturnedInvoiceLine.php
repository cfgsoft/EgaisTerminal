<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoiceLine extends Model
{
    protected $table = 'doc_returned_invoice_line';

    protected $fillable = ['lineid', 'productdescr', 'productcode', 'f1regid', 'f2regid',
        'quantity', 'quantity_mark', 'show_first', 'returned_invoice_id'];

    public function returnedInvoice(){
        return $this->belongsTo("App\Models\ReturnedInvoice\ReturnedInvoice");
    }
}
