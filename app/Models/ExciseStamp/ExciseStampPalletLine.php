<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStampPalletLine extends Model
{
    protected $table = 'excise_stamp_pallet_line';

    protected $fillable = ['pallet_id', 'box_id'];

    public function exciseStampPallet(){
        return $this->belongsTo("App\Models\ExciseStamp\ExciseStampPallet");
    }
}
