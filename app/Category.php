<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['descr', 'code', 'version', 'isMark'];
	
	public function products(){
	    return $this->hasMany("App\Product");
    }
}
