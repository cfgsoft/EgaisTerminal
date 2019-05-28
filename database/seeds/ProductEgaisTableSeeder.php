<?php

use Illuminate\Database\Seeder;

class ProductEgaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref_product_egais')->delete();

        DB::table('ref_product_egais')->insert(['descr' => 'Водка "ФИННОРД (FINNORD)" 40 % 0,1 л (ИнвестПартнер)', 'code' => '0037150000001399460', 'capacity' => '1', 'alc_volume' => '0', 'product_v_code' => '200']);
        DB::table('ref_product_egais')->insert(['descr' => 'SAN MARCO 1.0 Шардоне NEW', 'code' => '0123130000002476970', 'capacity' => '1', 'alc_volume' => '0', 'product_v_code' => '403']);
        DB::table('ref_product_egais')->insert(['descr' => 'SAN MARCO 1.0  Мерло NEW', 'code' => '0123130000002476973', 'capacity' => '1', 'alc_volume' => '0', 'product_v_code' => '403']);

    }
}
