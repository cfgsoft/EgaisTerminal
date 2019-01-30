<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceReadLine extends Model
{
    protected $table = 'doc_invoice_read_line';

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }
}
