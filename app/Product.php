<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['descr', 'code', 'version', 'ismark'];

	public funtion category(){
	    return $this->belongsTo("App\Category");
    }
}
