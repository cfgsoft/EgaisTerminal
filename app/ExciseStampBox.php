<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExciseStampBox extends Model
{
    protected $fillable = ['id', 'barcode', 'productcode','f1regid', 'f2regid'];

    public function excisestampboxlines(){
        return $this->hasMany("App\ExciseStampBoxLine");
    }
}
