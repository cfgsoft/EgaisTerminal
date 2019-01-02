<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoiceErrorLine extends Model
{
    protected $table = 'doc_returned_invoice_error_line';

    protected $fillable = ['markcode', 'message', 'returned_invoice_id'];

    public function returnedInvoice(){
        return $this->belongsTo("App\Models\ReturnedInvoice\ReturnedInvoice");
    }
}
