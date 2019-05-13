<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryErrorLine extends Model
{
    protected $table = 'doc_inventory_error_line';

    public function inventory(){
        return $this->belongsTo("App\Models\Inventory\Inventory");
    }
}
