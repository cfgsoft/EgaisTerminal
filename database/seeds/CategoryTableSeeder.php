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
            'isMark' => '0',
            'parent_id' => 0,
            'parent_code' => ''
        ]);

            DB::table('categories')->insert([
                'descr' => 'Baltika',
                'code' => '0000004',
                'version' => '1',
                'ismark' => '0',
                'parent_id' => 0,
                'parent_code' => '0000001'
            ]);

            DB::table('categories')->insert([
                'descr' => 'SunInbev',
                'code' => '0000005',
                'version' => '1',
                'ismark' => '0',
                'parent_id' => 0,
                'parent_code' => '0000001'
            ]);

        DB::table('categories')->insert([
            'descr' => 'Vodka',
            'code' => '0000002',
            'version' => '1',
            'isMark' => '0',
            'parent_id' => 0,
            'parent_code' => ''
        ]);

            DB::table('categories')->insert([
                'descr' => 'Belenkay',
                'code' => '0000006',
                'version' => '1',
                'isMark' => '0',
                'parent_id' => 0,
                'parent_code' => '0000002'
            ]);

        DB::table('categories')->insert([
            'descr' => 'Rosspiptprom',
            'code' => '0000007',
            'version' => '1',
            'isMark' => '0',
            'parent_id' => 0,
            'parent_code' => '0000002'
        ]);

        DB::table('categories')->insert([
            'descr' => 'Juice',
            'code' => '0000003',
            'version' => '1',
            'isMark' => '0',
            'parent_id' => 0,
            'parent_code' => ''
        ]);

            DB::table('categories')->insert([
                'descr' => 'WBD',
                'code' => '0000008',
                'version' => '1',
                'isMark' => '0',
                'parent_id' => 0,
                'parent_code' => '0000003'
            ]);

            DB::table('categories')->insert([
                'descr' => 'My family',
                'code' => '0000008',
                'version' => '1',
                'isMark' => '0',
                'parent_id' => 0,
                'parent_code' => '0000003'
            ]);

    }
}
