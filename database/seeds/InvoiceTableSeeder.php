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
                ],
                'marklines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => 'sgsagsdfhwert2345sgsryw34525'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => 'asgwrt234gasgsg2345235'
                    ]
                ],
                'packlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => '22222222'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => '444444444'
                    ]
                ],
                'palletlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => '555555555'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => '66666666'
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
                ],
                'marklines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => 'sgsagsdfhwert2345sgsryw34525'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => 'asgwrt234gasgsg2345235'
                    ]
                ],
                'packlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => '22222222'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => '444444444'
                    ]
                ],
                'palletlines' => [
                    '1' => [
                        'line_id' => '1',
                        'line_identifier' => '1',
                        'mark_code' => '555555555'
                    ],
                    '2' => [
                        'line_id' => '2',
                        'line_identifier' => '2',
                        'mark_code' => '66666666'
                    ]
                ],
            ],
        ];

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
                $invoiceLine->save();
            }

            foreach($i["marklines"] as $l) {
                $invoiceMarkLine = new InvoiceMarkLine;
                $invoiceMarkLine->invoice_id      = $invoice->id;
                $invoiceMarkLine->line_id         = $l["line_id"];
                $invoiceMarkLine->line_identifier = $l["line_identifier"];
                $invoiceMarkLine->mark_code       = $l["mark_code"];
                $invoiceMarkLine->save();
            }

            foreach($i["packlines"] as $l) {
                $invoicePackLine = new InvoicePackLine;
                $invoicePackLine->invoice_id      = $invoice->id;
                $invoicePackLine->line_id         = $l["line_id"];
                $invoicePackLine->line_identifier = $l["line_identifier"];
                $invoicePackLine->mark_code       = $l["mark_code"];
                $invoicePackLine->save();
            }

            foreach($i["palletlines"] as $l) {
                $invoicePalletLine = new InvoicePalletLine;
                $invoicePalletLine->invoice_id      = $invoice->id;
                $invoicePalletLine->line_id         = $l["line_id"];
                $invoicePalletLine->line_identifier = $l["line_identifier"];
                $invoicePalletLine->mark_code       = $l["mark_code"];
                $invoicePalletLine->save();
            }

        }

    }
}
