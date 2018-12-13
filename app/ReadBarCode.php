<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadBarCode extends Model
{
    protected $fillable = ['barcode', 'productcode', 'f1regid', 'f2regid'];

}
