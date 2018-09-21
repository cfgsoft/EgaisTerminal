<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(['descr' => 'Baltika', 'code' => '0000001', 'version' => '1', 'ismark' => '0', 'category_id' => 1]);
    }
}
