<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderErrorLine extends Model
{
    protected $fillable = ['markcode', 'message', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Models\Order\Order");
    }
}
