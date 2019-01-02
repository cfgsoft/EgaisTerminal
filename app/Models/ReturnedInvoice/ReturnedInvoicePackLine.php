<?php

namespace App\Models\ReturnedInvoice;

use Illuminate\Database\Eloquent\Model;

class ReturnedInvoicePackLine extends Model
{
    protected $table = 'doc_returned_invoice_pack_line';

    protected $fillable = ['lineid', 'f2regid', 'markcode', 'quantity', 'savedin1c', 'returned_invoice_id'];

    public function returnedInvoice(){
        return $this->belongsTo("App\Models\ReturnedInvoice\ReturnedInvoice");
    }
}
