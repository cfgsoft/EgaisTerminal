<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $table = 'doc_invoice_line';

    protected $fillable = ['line_id', 'line_identifier', 'product_descr', 'product_code', 'f1reg_id', 'f2reg_id', 'quantity'];

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }

}
