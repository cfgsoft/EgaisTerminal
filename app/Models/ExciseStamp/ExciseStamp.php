<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStamp extends Model
{
    protected $table = 'excise_stamp';

    protected $fillable = ['barcode', 'productcode','f1regid', 'f2regid', 'department_id'];

    //public $incrementing = false;
}
