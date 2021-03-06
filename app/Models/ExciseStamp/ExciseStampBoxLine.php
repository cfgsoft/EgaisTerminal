<?php

namespace App\Models\ExciseStamp;

use Illuminate\Database\Eloquent\Model;

class ExciseStampBoxLine extends Model
{
    protected $fillable = ['id', 'excise_stamp_box_id', 'markcode'];

    public function excisestampbox(){
        return $this->belongsTo("App\Models\ExciseStamp\ExciseStampBox");
    }
}
