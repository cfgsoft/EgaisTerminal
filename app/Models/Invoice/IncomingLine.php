<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomingLine extends Model
{
    protected $fillable = ['orderlineid', 'productdescr', 'productcode', 'f2regid', 'quantity',
        'quantitymarks', 'showfirst', 'incoming_id'];

    public function incoming(){
        return $this->belongsTo("App\Incoming");
    }
    
}
