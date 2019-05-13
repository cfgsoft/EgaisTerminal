<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryLine extends Model
{
    protected $table = 'doc_inventory_line';

    public function inventory(){
        return $this->belongsTo("App\Models\Inventory\Inventory");
    }
}
