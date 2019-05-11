<?php

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_inventory_error_line')->delete();
        DB::table('doc_inventory_pallet_line')->delete();;
        DB::table('doc_inventory_pack_line')->delete();
        DB::table('doc_inventory_mark_line')->delete();
        DB::table('doc_inventory_line')->delete();
        DB::table('doc_inventory')->delete();
    }
}
