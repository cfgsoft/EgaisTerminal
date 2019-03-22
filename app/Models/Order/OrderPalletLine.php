<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPalletLine extends Model
{
    protected $table = 'doc_order_pallet_line';

    protected $fillable = ['line_id', 'product_code', 'f2reg_id', 'mark_code', 'quantity'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
