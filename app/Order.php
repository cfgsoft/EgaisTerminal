<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['date', 'number', 'barcode', 'status'];

    public function orderlines(){
        return $this->hasMany("App\OrderLine");
    }

    public function ordermarklines(){
        return $this->hasMany("App\OrderMarkLine");
    }

    public function orderpacklines(){
        return $this->hasMany("App\OrderPackLine");
    }

    public function ordererrorlines(){
        return $this->hasMany("App\OrderErrorLine");
    }
}
