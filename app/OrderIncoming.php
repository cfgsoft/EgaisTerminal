<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderIncoming extends Model
{
    protected $fillable = ['date', 'number', 'barcode'];

    public function orderIncomingLines(){
        return $this->hasMany("App\OrderIncomingLine");
    }
}
