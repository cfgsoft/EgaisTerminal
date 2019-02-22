<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoicePalletLine extends Model
{
    protected $table = 'doc_invoice_pallet_line';

    protected $fillable = ['line_id', 'line_identifier', 'mark_code'];

    public function invoice(){
        return $this->belongsTo("App\Models\Invoice\Invoice");
    }
}
