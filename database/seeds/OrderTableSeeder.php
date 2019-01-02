<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Order;
use App\OrderLine;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_error_lines')->delete();
        DB::table('order_pack_lines')->delete();
        DB::table('order_mark_lines')->delete();
        DB::table('order_lines')->delete();
        DB::table('orders')->delete();

        //DB::table('order_error_lines')->truncate();
        //DB::table('order_error_lines')->truncate();
        //DB::table('order_pack_lines')->truncate();
        //DB::table('order_mark_lines')->truncate();
        //DB::table('order_lines')->truncate();
        //DB::table('orders')->truncate(); //Запрещена для таблиц с ForeignKey

        DB::table('orders')->insert(['id' =>  '9', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111434', 'barcode' => 'C13111434', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257bf-efe0-11e8-8ed6-0026832c8747']);
        DB::table('orders')->insert(['id' => '10', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111435', 'barcode' => 'C13111435', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257c0-efe0-11e8-8ed6-0026832c8747']);
        DB::table('orders')->insert(['id' => '11', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_000004', 'barcode' => 'AC13000004', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '7ef20513-fbb1-11e8-b84e-0026832c8747']);


        DB::table('order_lines')->insert(['id' =>  '7', 'order_id' => '9', 'orderlineid' => '1', 'productdescr' => 'Водка ФИННОРД 0.1л./30', 'productcode' => '0037150000001399460', 'quantity' => '1', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598237']);
        DB::table('order_lines')->insert(['id' =>  '8', 'order_id' => '9', 'orderlineid' => '2', 'productdescr' => 'Вино столовое полусладкое красное  МЕРЛО  САН МАРКО 1л/12', 'productcode' => '0123130000002476973', 'quantity' => '12', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598228']);

        DB::table('order_lines')->insert(['id' =>  '9', 'order_id' => '10', 'orderlineid' => '1', 'productdescr' => 'Вино столовое полусладкое белое  ШАРДОНЕ САН МАРКО 1л/12', 'productcode' => '0123130000002476970', 'quantity' => '2', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598232']);
        DB::table('order_lines')->insert(['id' =>  '10', 'order_id' => '10', 'orderlineid' => '2', 'productdescr' => 'Водка ФИННОРД 0.1л./30', 'productcode' => '0037150000001399460', 'quantity' => '3', 'quantitymarks' => '0', 'showfirst' => '0', 'f2regid' => 'FB-000001309598237']);

        DB::table('order_mark_lines')->insert(['id' =>  '10', 'order_id' => '10', 'orderlineid' => '1', 'productcode' => '0037150000001399460', 'quantity' => '1', 'savedin1c' => '0', 'markcode' => '101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
            'f2regid' => 'FB-000001309598232', 'boxnumber' => '0000000000000000']);


//        7	9	1	Водка ФИННОРД 0.1л./30	0037150000001399460	1	0	0	2018-12-13 12:27:07	2018-12-13 12:27:35	FB-000001309598237
//        8	9	2	Вино столовое полусладкое красное  "МЕРЛО"  САН МАРКО 1л/12	0123130000002476973	12	0	0	2018-12-13 12:27:07	2018-12-13 12:27:35	FB-000001309598228

//        9	16	1	Вино столовое полусладкое белое  "ШАРДОНЕ" САН МАРКО 1л/12	0123130000002476970	2	0	0	2018-12-13 12:27:08	2018-12-13 12:27:35	FB-000001309598232
//        10	16	2	Водка ФИННОРД 0.1л./30	0037150000001399460	3	0	0	2018-12-13 12:27:08	2018-12-13 12:27:35	FB-000001309598237

//        11	17	1	Вино столовое полусладкое белое  "ШАРДОНЕ" САН МАРКО 1л/12	0123130000002476970	1	0	0	2018-12-13 12:27:08	2018-12-13 12:27:35	FB-000001309598232
//        12	17	2	Водка ФИННОРД 0.1л./30	0037150000001399460	1	0	0	2018-12-13 12:27:08	2018-12-13 12:27:35	FB-000001309598237



        //DB::table('orders')->insert(['id' => '1', 'date' => Carbon::create('2018', '01', '01'), 'number' => '0000001', 'barcode' => '0000001', 'status' => '0']);
        //DB::table('orders')->insert(['id' => '2', 'date' => Carbon::create('2018', '01', '01'), 'number' => '0000002', 'barcode' => '0000002', 'status' => '0']);
        //DB::table('orders')->insert(['id' => '3', 'date' => Carbon::create('2018', '01', '01'), 'number' => '0000003', 'barcode' => '0000003', 'status' => '0']);

        //DB::table('order_lines')->insert(['productdescr' => 'Водка беленькая 0,5', 'productcode' => '0000001', 'quantity' => '20', 'quantitymarks' => '0', 'showfirst' => '0', 'order_id' => '1']);
        //DB::table('order_lines')->insert(['productdescr' => 'Водка ликсар 0,5',    'productcode' => '0000002', 'quantity' => '20', 'quantitymarks' => '0', 'showfirst' => '0', 'order_id' => '1']);

    }
}
