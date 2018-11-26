<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExciseStamp extends Model
{
    protected $fillable = ['id', 'productcode','f1regid', 'f2regid'];

    public $incrementing = false;
}
