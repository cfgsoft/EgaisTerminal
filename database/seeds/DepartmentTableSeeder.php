<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref_departments')->delete();
        DB::table('ref_departments')->insert(['id' => 1, 'descr' => 'Лопатина (Алкоголь)', 'name_short' => 'Алко плюс', 'code' => 'S00000001', 'lic' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('ref_departments')->insert(['descr' => 'ВашШанс (410001,РОССИЯ,,,САРАТОВ Г,,ОГОРОДНАЯ УЛ,36/42,,)', 'name_short' => 'Ваш шанс', 'code' => '030341891', 'lic' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
