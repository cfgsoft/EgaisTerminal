<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'ref_departments';

    protected $fillable = ['descr', 'code', 'version', 'mark', 'lic'];
}
