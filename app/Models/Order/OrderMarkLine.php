<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderMarkLine extends Model
{
    protected $table = 'doc_order_mark_line';

    protected $fillable = ['line_id', 'product_code', 'f2reg_id', 'markcode', 'pack_number',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
