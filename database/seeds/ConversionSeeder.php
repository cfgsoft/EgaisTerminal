<?php

use Illuminate\Database\Seeder;

use App\Models\ExciseStamp\ExciseStamp;

class ConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('excise_stamp')->delete();

        ExciseStamp::chunk(2000, function ($exciseStamps) {
            foreach ($exciseStamps as $item) {

                $newItem = [
                    'barcode' => $item->barcode,
                    'productcode' => $item->productcode,
                    'f1regid' => $item->f1regid,
                    'f2regid' => $item->f2regid,
                    'department_id' => $item->department_id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];

                DB::table('excise_stamp')->insert($newItem);

            }
        });
    }
}
