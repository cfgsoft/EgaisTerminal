<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Order\Order;
use App\Models\Order\OrderLine;
use App\Models\Order\OrderMarkLine;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_order_error_line')->delete();
        DB::table('doc_order_pallet_line')->delete();;
        DB::table('doc_order_pack_line')->delete();
        DB::table('doc_order_mark_line')->delete();
        DB::table('doc_order_line')->delete();
        DB::table('doc_order')->delete();

        $date = Carbon::create('2018', '11', '24');
        $dateOld = Carbon::create('2018', '10', '24');
        $dateNow = Carbon::now();

        $orders = [
            [
                'date' => $date,
                'number' => 'С13_111434',
                'barcode' => 'C13111434',
                'doc_type' => '1',
                'doc_id' => '30a257bf-efe0-11e8-8ed6-0026832c8747',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'product_descr' => 'Водка ФИННОРД 0.1л./30',
                        'product_code' => '0037150000001399460',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '15',
                        'quantity_mark' => '0',
                    ],
                    '2' => [
                        'line_id' => '2',
                        'product_descr' => 'Вино столовое полусладкое красное  \"МЕРЛО\"  САН МАРКО 1л/12',
                        'product_code' => '0123130000002476973',
                        'f2reg_id' => 'FB-000001309598228',
                        'quantity' => '12',
                        'quantity_mark' => '0',
                    ]
                ],
                'marklines' => []
            ],
            [
                'date' => $dateOld,
                'number' => 'С13_111433',
                'barcode' => 'C13111433',
                'doc_type' => '1',
                'doc_id' => '20a257bf-efe0-11e8-8ed6-0026832c8747',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'product_descr' => 'Водка ФИННОРД 0.1л./30',
                        'product_code' => '0037150000001399460',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '5',
                        'quantity_mark' => '2',
                    ],
                    '2' => [
                        'line_id' => '2',
                        'product_descr' => 'Вино столовое полусладкое красное  \"МЕРЛО\"  САН МАРКО 1л/12',
                        'product_code' => '0123130000002476973',
                        'f2reg_id' => 'FB-000001309598228',
                        'quantity' => '2',
                        'quantity_mark' => '0',
                    ]
                ],
                'marklines' => [
                    '1' => [
                        'line_id' => '1',
                        'product_code' => '0037150000001399460',
                        'markcode' => '201100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '1',
                        'created_at' => $dateOld
                    ],
                    '2' => [
                        'line_id' => '1',
                        'product_code' => '0037150000001399460',
                        'markcode' => '301100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '1',
                        'created_at' => $dateNow
                    ]
                ]
            ],
        ];

        foreach($orders as $i)
        {
            $order = new Order;
            $order->date     = $i["date"];
            $order->number   = $i["number"];
            $order->barcode  = $i["barcode"];
            $order->status   = 0;
            $order->quantity       = 0;
            $order->Quantity_mark  = 0;
            $order->doc_type = $i["doc_type"];
            $order->doc_id   = $i["doc_id"];
            $order->save();

            foreach($i["lines"] as $l) {
                $orderLine = new OrderLine;
                $orderLine->order_id      = $order->id;
                $orderLine->line_id       = $l["line_id"];
                $orderLine->product_descr = $l["product_descr"];
                $orderLine->product_code  = $l["product_code"];
                $orderLine->quantity      = $l["quantity"];
                $orderLine->quantity_mark = $l["quantity_mark"];
                $orderLine->f2reg_id      = $l["f2reg_id"];
                $orderLine->show_first    = 0;
                $orderLine->save();
            }

            foreach($i["marklines"] as $l) {
                $orderLine = new OrderMarkLine;
                $orderLine->order_id      = $order->id;
                $orderLine->line_id       = $l["line_id"];
                $orderLine->product_code  = $l["product_code"];
                $orderLine->markcode      = $l["markcode"];
                $orderLine->quantity      = $l["quantity"];
                $orderLine->f2reg_id      = $l["f2reg_id"];
                $orderLine->savedin1c     = 0;
                $orderLine->pack_number   = '000000000000000000000';
                $orderLine->created_at    = $l["created_at"];
                $orderLine->updated_at    = $i["date"];
                $orderLine->save();
            }
        }


        /*
        {
        "date": "2018-11-24T15:58:28",
        "number": "С13_111434",
        "barcode": "C13111434",
        "doc_type": 1,
        "doc_id": "30a257bf-efe0-11e8-8ed6-0026832c8747",
        "lines": [
            {
            "line_id": 1,
            "product_descr": "Водка ФИННОРД 0.1л./30",
            "product_code": "0037150000001399460",
            "f2reg_id": "FB-000001309598237",
            "quantity": "1"
            },
            {
            "line_id": 2,
            "product_descr": "Вино столовое полусладкое красное  \"МЕРЛО\"  САН МАРКО 1л/12",
            "product_code": "0123130000002476973",
            "f2reg_id": "FB-000001309598228",
            "quantity": "12"
            }
        ]
        }
        {
        "date": "2018-11-24T16:00:16",
        "number": "С13_111435",
        "barcode": "C13111435",
        "doc_type": 1,
        "doc_id": "30a257c0-efe0-11e8-8ed6-0026832c8747",
        "lines": [
            {
            "line_id": 1,
            "product_descr": "Вино столовое полусладкое белое  \"ШАРДОНЕ\" САН МАРКО 1л/12",
            "product_code": "0123130000002476970",
            "f2reg_id": "FB-000001309598232",
            "quantity": "2"
            },
            {
            "line_id": 2,
            "product_descr": "Водка ФИННОРД 0.1л./30",
            "product_code": "0037150000001399460",
            "f2reg_id": "FB-000001309598237",
            "quantity": "3"
            }
        ]
        }
        */

        /*
        $source = '{
            "info": {
            "q_title": "hello",
            "q_description": "ddd",
            "q_visibility": "1",
            "start_date": "Thu, 05 Oct 2017 06:11:00 GMT"
            }
        }';
        $data = json_decode($source, true);
        echo $data['info']['q_title'];
        */






        //DB::table('order_error_lines')->truncate();
        //DB::table('order_error_lines')->truncate();
        //DB::table('order_pack_lines')->truncate();
        //DB::table('order_mark_lines')->truncate();
        //DB::table('order_lines')->truncate();
        //DB::table('orders')->truncate(); //Запрещена для таблиц с ForeignKey

//        DB::table('orders')->insert(['id' =>  '9', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111434', 'barcode' => 'C13111434', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257bf-efe0-11e8-8ed6-0026832c8747']);
//        DB::table('orders')->insert(['id' => '10', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111435', 'barcode' => 'C13111435', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257c0-efe0-11e8-8ed6-0026832c8747']);
//        DB::table('orders')->insert(['id' => '11', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_000004', 'barcode' => 'AC13000004', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '7ef20513-fbb1-11e8-b84e-0026832c8747']);
//
//
//        DB::table('order_lines')->insert(['id' =>  '7', 'order_id' => '9', 'orderlineid' => '1', 'productdescr' => 'Водка ФИННОРД 0.1л./30', 'productcode' => '0037150000001399460', 'quantity' => '1', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598237']);
//        DB::table('order_lines')->insert(['id' =>  '8', 'order_id' => '9', 'orderlineid' => '2', 'productdescr' => 'Вино столовое полусладкое красное  МЕРЛО  САН МАРКО 1л/12', 'productcode' => '0123130000002476973', 'quantity' => '12', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598228']);
//
//        DB::table('order_lines')->insert(['id' =>  '9', 'order_id' => '10', 'orderlineid' => '1', 'productdescr' => 'Вино столовое полусладкое белое  ШАРДОНЕ САН МАРКО 1л/12', 'productcode' => '0123130000002476970', 'quantity' => '2', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598232']);
//        DB::table('order_lines')->insert(['id' =>  '10', 'order_id' => '10', 'orderlineid' => '2', 'productdescr' => 'Водка ФИННОРД 0.1л./30', 'productcode' => '0037150000001399460', 'quantity' => '3', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598237']);
//
//        DB::table('order_mark_lines')->insert(['id' =>  '10', 'order_id' => '10', 'orderlineid' => '1', 'productcode' => '0037150000001399460', 'quantity' => '1', 'savedin1c' => '0', 'markcode' => '101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
//            'f2regid' => 'FB-000001309598232', 'boxnumber' => '0000000000000000']);


    }
}
