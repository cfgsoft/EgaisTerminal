<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStamp extends Model
{
    protected $fillable = ['id', 'productcode','f1regid', 'f2regid'];

    public $incrementing = false;
}
