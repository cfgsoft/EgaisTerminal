<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = ['productdescr', 'productcode', 'quantity',
                           'quantitymarks', 'showfirst', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Order");
    }
}
