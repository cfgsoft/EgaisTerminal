<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = ['orderlineid', 'productdescr', 'productcode', 'f2regid', 'quantity',
                           'quantitymarks', 'showfirst', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Order");
    }
}
