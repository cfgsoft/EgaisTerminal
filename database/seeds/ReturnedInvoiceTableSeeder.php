<?php

use Illuminate\Database\Seeder;

class ReturnedInvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_returned_invoice_mark_line')->delete();
        DB::table('doc_returned_invoice_line')->delete();
        DB::table('doc_returned_invoice')->delete();

        //DB::table('orders')->insert(['id' =>  '9', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111434', 'barcode' => 'C13111434', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257bf-efe0-11e8-8ed6-0026832c8747']);
        //DB::table('orders')->insert(['id' => '10', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_111435', 'barcode' => 'C13111435', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '30a257c0-efe0-11e8-8ed6-0026832c8747']);
        //DB::table('orders')->insert(['id' => '11', 'date' => Carbon::create('2018', '11', '24'), 'number' => 'С13_000004', 'barcode' => 'AC13000004', 'status' => '0', 'Quantity' => '0', 'QuantityMarks' => '0', 'DocType' => '1', 'DocId' => '7ef20513-fbb1-11e8-b84e-0026832c8747']);

    }
}
