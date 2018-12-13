<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReadBarCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('read_bar_codes')->delete();
        DB::table('read_bar_codes')->insert(['barcode' => 'seed1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('read_bar_codes')->insert(['barcode' => 'seed2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('read_bar_codes')->insert(['barcode' => 'seed3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
