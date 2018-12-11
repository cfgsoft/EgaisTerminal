<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMarkLine extends Model
{
    protected $fillable = ['orderlineid', 'productcode', 'f2regid', 'markcode', 'boxnumber',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Order");
    }
}
