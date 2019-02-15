<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPackLine extends Model
{
    protected $fillable = ['orderlineid', 'productcode', 'f2regid', 'markcode',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
