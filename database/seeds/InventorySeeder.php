<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryLine;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_inventory_error_line')->delete();
        DB::table('doc_inventory_pallet_line')->delete();;
        DB::table('doc_inventory_pack_line')->delete();
        DB::table('doc_inventory_mark_line')->delete();
        DB::table('doc_inventory_line')->delete();
        DB::table('doc_inventory')->delete();


        $date = Carbon::create('2019', '04', '24');
        $dateNew = Carbon::create('2019', '05', '20');

        $inventorys = [
            [
                'date' => $date,
                'number' => '111111111',
                'department_id' => 1,
                'quantity_mark' => 2,
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'product_code' => '1111111111',
                        'product_descr' => 'товар 1',
                        'product_id' => '111111',
                        'f2reg_id' => '22222',
                        'quantity' => '4'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'product_code' => '2222222222',
                        'product_descr' => 'товар 2',
                        'product_id' => '22222',
                        'f2reg_id' => '33333',
                        'quantity' => '7'
                    ]
                ]
            ],
            [
                'date' => $dateNew,
                'number' => 'С13_000001',
                'department_id' => 1,
                'quantity_mark' => 5,
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'product_code' => '111111111111',
                        'product_descr' => 'Водка ФИННОРД 0.1л./30',
                        'product_id' => '3715',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '15'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'product_code' => '2222222222',
                        'product_descr' => 'Вино столовое полусладкое красное  \"МЕРЛО\"  САН МАРКО 1л/12',
                        'product_id' => '12313',
                        'f2reg_id' => 'FB-000001309598228',
                        'quantity' => '12'
                    ]
                ]
            ],
        ];

        foreach($inventorys as $i)
        {
            $inventory = new Inventory;
            $inventory->date           = $i["date"];
            $inventory->number         = $i["number"];
            $inventory->department_id  = $i["department_id"];
            $inventory->quantity_mark  = $i["quantity_mark"];
            $inventory->save();

            foreach($i["lines"] as $l) {
                $inventoryLine = new InventoryLine;
                $inventoryLine->inventory_id   = $inventory->id;
                $inventoryLine->line_id        = $l['line_id'];
                $inventoryLine->product_code   = $l['product_code'];
                $inventoryLine->product_id     = $l['product_id'];
                $inventoryLine->product_descr  = $l['product_descr'];
                $inventoryLine->f2reg_id       = $l['f2reg_id'];
                $inventoryLine->quantity       = $l['quantity'];
                $inventoryLine->show_first     = 0;
                $inventoryLine->save();
            }
        }

    }
}
