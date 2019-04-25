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
        DB::table('ref_departments')->insert(['descr' => 'Лопатина (Алкоголь)', 'code' => 'S00000001', 'lic' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('ref_departments')->insert(['descr' => 'ВашШанс (410001,РОССИЯ,,,САРАТОВ Г,,ОГОРОДНАЯ УЛ,36/42,,)', 'code' => '030341891', 'lic' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
