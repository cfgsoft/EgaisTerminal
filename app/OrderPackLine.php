<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPackLine extends Model
{
    protected $fillable = ['ordermarklineid', 'productcode', 'f2regid', 'markcode',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Order");
    }
}
