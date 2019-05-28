<?php

namespace App\Models\RefEgais;

use Illuminate\Database\Eloquent\Model;

class ProductEgais extends Model
{
    protected $table = 'ref_product_egais';

    protected $fillable = ['descr', 'code', 'capacity', 'alc_volume', 'product_v_code', 'version'];

    public function exciseStamps(){
        return $this->hasMany("App\Models\ExciseStamp\ExciseStamp", "productcode", "code");
    }
}
