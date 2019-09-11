<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\ReturnedInvoice\ReturnedInvoice;
use App\Models\ReturnedInvoice\ReturnedInvoiceLine;

class ReturnedInvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_returned_invoice_error_line')->delete();
        //DB::table('doc_returned_invoice_pack_line')->delete();
        DB::table('doc_returned_invoice_mark_line')->delete();
        DB::table('doc_returned_invoice_line')->delete();
        DB::table('doc_returned_invoice')->delete();

        $date = Carbon::create('2018', '11', '24');
        $dateNew = Carbon::create('2019', '02', '20');

        $returnedInvoices = [
            [
                'date' => $date,
                'number' => '111111111',
                'barcode' => '111111111',
                'doc_type' => '4',
                'doc_id' => '114TD2B2BLqXhCAEdltKSio2lhsfPWB95I9L',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'product_descr' => 'товар',
                        'product_code' => '111111',
                        'f1reg_id' => '1111',
                        'f2reg_id' => '22222',
                        'quantity' => '10'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'product_descr' => 'товар',
                        'product_code' => '111111',
                        'f1reg_id' => '1111',
                        'f2reg_id' => '22222',
                        'quantity' => '5'
                    ]
                ]
            ],
            [
                'date' => $dateNew,
                'number' => 'С13_000001',
                'barcode' => 'C13000001',
                'doc_type' => '4',
                'doc_id' => '30a257bf-efe0-11e8-8ed6-0026832c8748',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'product_descr' => 'Водка ФИННОРД 0.1л./30',
                        'product_code' => '0037150000001399460',
                        'f1reg_id' => 'FA-000000039597226',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '15'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'product_descr' => 'Вино столовое полусладкое красное  \"МЕРЛО\"  САН МАРКО 1л/12',
                        'product_code' => '0123130000002476973',
                        'f1reg_id' => 'FA-000000039565813',
                        'f2reg_id' => 'FB-000001309598228',
                        'quantity' => '12'
                    ]
                ]
            ],
        ];

        foreach($returnedInvoices as $i)
        {
            $returnedInvoice = new ReturnedInvoice;
            $returnedInvoice->date     = $i["date"];
            $returnedInvoice->number   = $i["number"];
            $returnedInvoice->barcode  = $i["barcode"];
            $returnedInvoice->doc_type = $i["doc_type"];
            $returnedInvoice->doc_id   = $i["doc_id"];
            $returnedInvoice->save();

            foreach($i["lines"] as $l) {
                $invoiceLine = new ReturnedInvoiceLine;
                $invoiceLine->returned_invoice_id      = $returnedInvoice->id;
                $invoiceLine->lineid         = $l["line_id"];
                $invoiceLine->productdescr   = $l["product_descr"];
                $invoiceLine->productcode    = $l["product_code"];
                $invoiceLine->f1regid   = $l["f1reg_id"];
                $invoiceLine->f2regid   = $l["f2reg_id"];
                $invoiceLine->quantity   = $l["quantity"];
                $invoiceLine->show_first   = 0;
                $invoiceLine->save();
            }
        }

    }
}
