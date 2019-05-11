<?php

namespace App\Models\Inventory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'doc_inventory';

    protected $fillable = ['date', 'number', 'department_id'];

    public static function add($fields)
    {
        $inventory = new static;
        $inventory->fill($fields);
        $inventory->date = Carbon::now();
        $inventory->number = '1';
        $inventory->department_id = 1;
        $inventory->save();

        return $inventory;
    }
}
