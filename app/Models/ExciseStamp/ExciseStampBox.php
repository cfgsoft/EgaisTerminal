<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStampBox extends Model
{
    protected $fillable = ['barcode', 'productcode','f1regid', 'f2regid'];

    public function excisestampboxlines(){
        return $this->hasMany("App\Models\ExciseStamp\ExciseStampBoxLine");
    }
}
