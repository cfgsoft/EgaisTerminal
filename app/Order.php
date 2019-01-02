<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['date', 'number', 'barcode', 'status',
        'Quantity', 'QuantityMarks', 'DocType', 'DocId'];

    public function orderlines(){
        return $this->hasMany("App\OrderLine");
    }

    public function ordermarklines(){
        return $this->hasMany("App\OrderMarkLine");
    }

    public function orderpacklines(){
        return $this->hasMany("App\OrderPackLine");
    }

    public function ordererrorlines(){
        return $this->hasMany("App\OrderErrorLine");
    }

    public function removeLineF2RegId($f2regid)
    {
        if($f2regid == null) { return; }

        OrderPackLine::where([ ['order_id','=',$this->id], ['f2regid','=',$f2regid] ])->delete();
        $deletedRows = OrderMarkLine::where([ ['order_id','=',$this->id], ['f2regid','=',$f2regid] ])->delete();

        return $deletedRows;
    }

}
