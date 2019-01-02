<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $fillable = ['date', 'number', 'barcode'];

    public function incomingLines(){
        return $this->hasMany("App\IncomingLine");
    }
}
