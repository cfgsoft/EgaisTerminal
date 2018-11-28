<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderIncomingLine extends Model
{
    protected $fillable = ['orderlineid', 'productdescr', 'productcode', 'f2regid', 'quantity',
        'quantitymarks', 'showfirst', 'order_incoming_id'];

    public function orderIncoming(){
        return $this->belongsTo("App\OrderIncoming");
    }
    
}
