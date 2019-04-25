<?php

use Illuminate\Database\Seeder;

use App\Models\Order\OrderErrorLine;
use App\Models\ExciseStamp\ExciseStamp;

class OrderErrorLineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$orderErrorLines = App\OrderErrorLine::all();
        //foreach ($orderErrorLines as $orderErrorLine) {
        //    echo $flight->name;
        //}

        OrderErrorLine::chunk(200, function ($orderErrorLines) {
            foreach ($orderErrorLines as $orderErrorLine) {
                //
                if ($orderErrorLine->product_code != null) {
                    continue;
                }

                if (strlen($orderErrorLine->markcode) == 150) {

                    $exciseStamp = ExciseStamp::find($orderErrorLine->markcode);
                    if ($exciseStamp != null) {
                        $orderErrorLine->product_code = $exciseStamp->productcode;
                        $orderErrorLine->f2reg_id = $exciseStamp->f2regid;
                        $orderErrorLine->save();
                    }
                }

            }
        });

    }
}
