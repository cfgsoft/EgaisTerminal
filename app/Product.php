<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'ref_products';

	protected $fillable = ['descr', 'code', 'version', 'ismark', 'category_id'];

	public function category(){
	    return $this->belongsTo("App\Category");
    }
}
