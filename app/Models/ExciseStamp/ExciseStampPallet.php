<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStampPallet extends Model
{
    protected $table = 'excise_stamp_pallet';

    protected $fillable = ['barcode', 'productcode','f1regid', 'f2regid'];

    public function exciseStampPalletLines(){
        return $this->hasMany("App\Models\ExciseStamp\ExciseStampPalletLine", "pallet_id");
    }
}
