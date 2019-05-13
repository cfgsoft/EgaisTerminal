<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = Department::firstOrNew(['id' => '1']);
        if (!$department->exists) {
            $department->id = '1';
            $department->descr = 'Лопатина (Алкоголь)';
            $department->name_short = 'Алко плюс';
            $department->code = 'S00000001';
            $department->lic = false;
            $department->created_at = Carbon::now();
            $department->updated_at = Carbon::now();
            $department->save();
        }

        $department = Department::firstOrNew(['id' => '2']);
        if (!$department->exists) {
            $department->id = '2';
            $department->descr = 'ВашШанс (410001,РОССИЯ,,,САРАТОВ Г,,ОГОРОДНАЯ УЛ,36/42,,)';
            $department->name_short = 'Ваш шанс';
            $department->code = '030341891';
            $department->lic = true;
            $department->created_at = Carbon::now();
            $department->updated_at = Carbon::now();
            $department->save();
        }

        //DB::table('ref_departments')->where(['id','<>','1'])->delete();
        //DB::table('ref_departments')->insert(['id' => 1, 'descr' => 'Лопатина (Алкоголь)', 'name_short' => 'Алко плюс', 'code' => 'S00000001', 'lic' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        //DB::table('ref_departments')->insert(['descr' => 'ВашШанс (410001,РОССИЯ,,,САРАТОВ Г,,ОГОРОДНАЯ УЛ,36/42,,)', 'name_short' => 'Ваш шанс', 'code' => '030341891', 'lic' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
