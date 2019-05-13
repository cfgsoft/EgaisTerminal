<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryMarkLine extends Model
{
    protected $table = 'doc_inventory_mark_line';

    public function inventory(){
        return $this->belongsTo("App\Models\Inventory\Inventory");
    }
}
