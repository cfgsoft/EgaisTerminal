<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStamp extends Model
{
    protected $table = 'excise_stamp';

    protected $fillable = ['productcode','f1regid', 'f2regid', 'department_id', 'barcode'];

    //public $incrementing = false;
}
