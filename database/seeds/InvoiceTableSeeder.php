<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceLine;
use App\Models\Invoice\InvoiceMarkLine;
use App\Models\Invoice\InvoicePackLine;
use App\Models\Invoice\InvoicePalletLine;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_invoice_error_line')->delete();
        DB::table('doc_invoice_pallet_line')->delete();
        DB::table('doc_invoice_pack_line')->delete();
        DB::table('doc_invoice_mark_line')->delete();
        DB::table('doc_invoice_read_line')->delete();
        DB::table('doc_invoice_line')->delete();
        DB::table('doc_invoice')->delete();

        $date = Carbon::create('2018', '11', '24');
        //$date = Carbon::now();

        $invoices = [
            [
                'date' => $date,
                'number' => '111111111',
                'barcode' => '111111111',
                'doc_type' => '3',
                'doc_id' => '11YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9L',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'product_descr' => 'Настойка горькая ПЕРЦОВОЧКА С МЕДОМ',
                        'product_code' => '0378114000001323864',
                        'f1reg_id' => 'FA-000000039597226',
                        'f2reg_id' => 'FB-000001309598237',
                        'quantity' => '10',
                        'quantity_pack' => '2',
                        'quantity_pallet' => '1'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'product_descr' => 'Настойка горькая ПЕРЦОВОЧКА',
                        'product_code' => '0123130000002476973',
                        'f1reg_id' => 'FA-000000039565813',
                        'f2reg_id' => 'FB-000001309598228',
                        'quantity' => '5',
                        'quantity_pack' => '1',
                        'quantity_pallet' => '1'
                    ]
                ],
                'marklines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => '401100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
                        'pack_number' => '02000000029510118000087245'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => '501100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI',
                        'pack_number' => '02000000029510118000087245'
                    ]
                ],
                'packlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'pack_number' => '02000000029510118000087245',
                        'pallet_number' => '03000000029510118000087245'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'pack_number' => '01000000054710219024019879',
                        'pallet_number' => '05000000029510118000087245'
                    ]
                ],
                'palletlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'pallet_number' => '03000000029510118000087245'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'pallet_number' => '05000000029510118000087245'
                    ]
                ],
            ],
            [
                'date' => $date,
                'number' => '211111111',
                'barcode' => '211111111',
                'doc_type' => '3',
                'doc_id' => '12YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9L',
                'lines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'product_descr' => 'товар',
                        'product_code' => '111111',
                        'f1reg_id' => '1111',
                        'f2reg_id' => '22222',
                        'quantity' => '10',
                        'quantity_pack' => '2',
                        'quantity_pallet' => '1'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'product_descr' => 'товар',
                        'product_code' => '111111',
                        'f1reg_id' => '1111',
                        'f2reg_id' => '22222',
                        'quantity' => '5',
                        'quantity_pack' => '1',
                        'quantity_pallet' => '1'
                    ]
                ],
                'marklines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => 'sgsagsdfhwert2345sgsryw34525',
                        'pack_number' => null
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => 'asgwrt234gasgsg2345235',
                        'pack_number' => null
                    ]
                ],
                'packlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'pack_number' => '22222222',
                        'pallet_number' => null
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'pack_number' => '444444444',
                        'pallet_number' => null
                    ]
                ],
                'palletlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'pallet_number' => '555555555'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'pallet_number' => '66666666'
                    ]
                ],
            ],
        ];

        /*
        [
            'date' => $date,
            'number' => 'S0000107520',
            'barcode' => 'DS0000107520',
            'incoming_number' => 'ЛРнК-023196',
            'incoming_date' => $date,
            'sum' => 977351.16,
            'doc_type' => '3',
            'doc_id' => '82385a70-3115-11e9-96a5-80c16e6f141f',
            'lines' => [
                '1' => [
                    'line_id' => '1',
                    'line_identifier' => '1',
                    'product_descr' => 'Настойка горькая ПЕРЦОВОЧКА С МЕДОМ',
                    'product_code' => '0378114000001323864',
                    'f1reg_id' => 'FA-000000042379795',
                    'f2reg_id' => 'FB-000002131644408',
                    'quantity' => '1140'
                ],
                '2' => [
                    'line_id' => '2',
                    'line_identifier' => '2',
                    'product_descr' => 'Настойка горькая ПЕРЦОВОЧКА',
                    'product_code' => '0378114000001323862',
                    'f1reg_id' => 'FA-000000042192772',
                    'f2reg_id' => 'FB-000002131644403',
                    'quantity' => '1080'
                ],
            ]

        ]
        */

        foreach($invoices as $i)
        {
            $invoice = new Invoice;
            $invoice->date     = $i["date"];
            $invoice->number   = $i["number"];
            $invoice->barcode  = $i["barcode"];
            $invoice->doc_type = $i["doc_type"];
            $invoice->doc_id   = $i["doc_id"];
            $invoice->save();

            foreach($i["lines"] as $l) {
                $invoiceLine = new InvoiceLine;
                $invoiceLine->invoice_id      = $invoice->id;
                $invoiceLine->line_id         = $l["line_id"];
                $invoiceLine->line_identifier = $l["line_identifier"];
                $invoiceLine->product_descr   = $l["product_descr"];
                $invoiceLine->product_code    = $l["product_code"];
                $invoiceLine->f1reg_id   = $l["f1reg_id"];
                $invoiceLine->f2reg_id   = $l["f2reg_id"];
                $invoiceLine->quantity   = $l["quantity"];
                $invoiceLine->quantity_pack   = $l["quantity_pack"];
                $invoiceLine->quantity_pallet = $l["quantity_pallet"];
                $invoiceLine->save();
            }

            foreach($i["marklines"] as $l) {
                $invoiceMarkLine = new InvoiceMarkLine;
                $invoiceMarkLine->invoice_id      = $invoice->id;
                $invoiceMarkLine->line_id         = $l["line_id"];
                $invoiceMarkLine->line_identifier = $l["line_identifier"];
                $invoiceMarkLine->mark_code       = $l["mark_code"];
                $invoiceMarkLine->pack_number     = $l["pack_number"];
                $invoiceMarkLine->save();
            }

            foreach($i["packlines"] as $l) {
                $invoicePackLine = new InvoicePackLine;
                $invoicePackLine->invoice_id      = $invoice->id;
                $invoicePackLine->line_id         = $l["line_id"];
                $invoicePackLine->line_identifier = $l["line_identifier"];
                $invoicePackLine->pack_number     = $l["pack_number"];
                $invoicePackLine->pallet_number   = $l["pallet_number"];
                $invoicePackLine->save();
            }

            foreach($i["palletlines"] as $l) {
                $invoicePalletLine = new InvoicePalletLine;
                $invoicePalletLine->invoice_id      = $invoice->id;
                $invoicePalletLine->line_id         = $l["line_id"];
                $invoicePalletLine->line_identifier = $l["line_identifier"];
                $invoicePalletLine->pallet_number   = $l["pallet_number"];
                $invoicePalletLine->save();
            }

        }

    }
}
