<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceErrorLine extends Model
{
    protected $table = 'doc_invoice_error_line';

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }
}
