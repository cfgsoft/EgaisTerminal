<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMarkLine extends Model
{
    protected $fillable = ['ordermarklineid', 'productcode', 'markcode',
                           'quantity', 'savedin1c', 'order_id'];

    public function order(){
        return $this->belongsTo("App\Order");
    }
}
