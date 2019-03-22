<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = 'doc_order_line';

    protected $fillable = ['line_id', 'product_descr', 'product_code', 'f2reg_id', 'quantity',
                           'quantity_mark', 'show_first', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
