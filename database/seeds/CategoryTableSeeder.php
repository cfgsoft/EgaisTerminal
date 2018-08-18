<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'descr' => 'Beer',
            'code' => '0000001',
            'version' => '1',
            'isMark' => '0'
        ]);

        DB::table('categories')->insert([
            'descr' => 'Vodka',
            'code' => '0000002',
            'version' => '1',
            'isMark' => '0'
        ]);

        DB::table('categories')->insert([
            'descr' => 'Juice',
            'code' => '0000003',
            'version' => '1',
            'isMark' => '0'
        ]);
    }
}
