<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

use App\Models\Invoice\Invoice;
use App\User;

class InvoiceTest extends TestCase
{
    const DOC_ID_ADD = 'YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9LQa';
    const DOC_ID_UPD = '11YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9L';

    private $token;
    private $headers;

    public function setUp()
    {
        parent::setUp();

        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $this->token = $user->generateToken();
        $this->headers = ['Authorization' => "Bearer $this->token"];
    }

    private function newInvoice()
    {
        $date = Carbon::now();
        $number = str_random(11);
        $barcode = str_random(12);

        $payload = [
            'date' => $date,
            'number' => $number,
            'barcode' => $barcode,
            'doc_type' => '3',
            'doc_id' => InvoiceTest::DOC_ID_ADD,
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
                    'quantity_pack' => '2',
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
            ]
        ];

        //if (array_key_exists('packlines', $payload)) {
        //    echo "Массив содержит элемент 'packlines'.";
        //}

        return $payload;
    }

    private function newInvoiceBig()
    {
        $date = Carbon::now();
        $number = str_random(11);
        $barcode = str_random(12);
        $doc_id = 'STD2B2BLqXhCAEdltKSio2lhsfPWB95I9LQa';

        $payload = [
            'date' => $date,
            'number' => $number,
            'barcode' => $barcode,
            'doc_type' => '3',
            'doc_id' => $doc_id,
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
                    'pack_number' => '22222222'
                ],
                '2' => [
                    'line_id' => '2',
                    'line_identifier' => '2',
                    'pack_number' => '444444444'
                ]
            ]
        ];

        for ($i = 1; $i < 10000; $i++)
        {
            $markline = [
                'line_id' => $i,
                'line_identifier' => $i,
                'mark_code' => str_random(36)
                ];

            array_push($payload['marklines'], $markline);
        }

        //if (array_key_exists('packlines', $payload)) {
        //    echo "Массив содержит элемент 'packlines'.";
        //}

        return $payload;
    }

    private function newInvoiceMark()
    {
        $date = Carbon::now();
        $number = str_random(11);
        $barcode = str_random(12);

        $payload = [
            'date' => $date,
            'number' => $number,
            'barcode' => $barcode,
            'doc_type' => '3',
            'doc_id' => InvoiceTest::DOC_ID_ADD,
            'marklines' => [
                '1' => [
                    'line_id' => '1',
                    'line_identifier' => '1',
                    'mark_code' => '1sgsagsdfhwert2345sgsryw34525',
                    'pack_number' => '02000000029510118000087245'
                ],
                '2' => [
                    'line_id' => '2',
                    'line_identifier' => '2',
                    'mark_code' => '1asgwrt234gasgsg2345235',
                    'pack_number' => '02000000029510118000087245'
                ]
            ]
        ];

        for ($i = 1; $i < 10; $i++)
        {
            $markline = [
                'line_id' => $i,
                'line_identifier' => $i,
                'mark_code' => str_random(36)
            ];

            array_push($payload['marklines'], $markline);
        }

        return $payload;
    }


    public function testApiInvoiceStatus()
    {
        $response = $this->get('/api/v1/invoices', $this->headers);
        $response->assertStatus(200);
    }

    public function testApiInvoiceAreCreatedCorrectly()
    {
        //https://softobzor.com.ua/laravel-restful-api-testirovanie/

        $payload = $this->newInvoice();
        //$payload = $this->newInvoiceBig();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload, $this->headers);
        $response->assertStatus(201)
                 ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreUpdatedCorrectly()
    {
        $payload = $this->newInvoice();

        $invoice = Invoice::where('doc_id', InvoiceTest::DOC_ID_UPD)->first();

        $payload['doc_id'] = $invoice->doc_id;
        $payload['number'] = $invoice->number;
        $payload['barcode'] = $invoice->barcode;

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload, $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceMarkAreUpdatedCorrectly()
    {
        $payload = $this->newInvoiceMark();

        $invoice = Invoice::where('doc_id', InvoiceTest::DOC_ID_UPD)->first();

        $number  = $invoice->number;
        $barcode = $invoice->barcode;

        $response = $this->put('/api/v1/invoices/' . $invoice->id , $payload, $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreListedCorrectly()
    {
        $response = $this->get('/api/v1/invoices', $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['current_page' => 1])
            ->assertJsonFragment(['doc_id' => InvoiceTest::DOC_ID_ADD]);

    }
}
