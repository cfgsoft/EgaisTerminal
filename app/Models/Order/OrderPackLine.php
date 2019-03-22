<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPackLine extends Model
{
    protected $table = 'doc_order_pack_line';

    protected $fillable = ['line_id', 'product_code', 'f2reg_id', 'pack_number', 'pallet_number',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
