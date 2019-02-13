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
    const DOC_ID = 'YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9LQa';

    public static $token = '';
    public static $headers =[];

    public function setUp()
    {
        parent::setUp();

        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        //self::$token = $user->generateToken();
        //self::$headers = ['Authorization' => "Bearer $token"];
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
            'doc_id' => InvoiceTest::DOC_ID,
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
                    'mark_code' => '22222222'
                ],
                '2' => [
                    'line_id' => '2',
                    'line_identifier' => '2',
                    'mark_code' => '444444444'
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
            'doc_id' => InvoiceTest::DOC_ID,
            'marklines' => [
                '1' => [
                    'line_id' => '1',
                    'line_identifier' => '1',
                    'mark_code' => '1sgsagsdfhwert2345sgsryw34525'
                ],
                '2' => [
                    'line_id' => '2',
                    'line_identifier' => '2',
                    'mark_code' => '1asgwrt234gasgsg2345235'
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
        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->get('/api/v1/invoices', $headers);
        $response->assertStatus(200);
    }

    public function testApiInvoiceAreCreatedCorrectly()
    {
        //https://softobzor.com.ua/laravel-restful-api-testirovanie/

        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = $this->newInvoice();
        //$payload = $this->newInvoiceBig();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload, $headers);
        $response->assertStatus(201)
                 ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreUpdatedCorrectly()
    {
        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = $this->newInvoice();

        $invoice = Invoice::where('doc_id', '11YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9L')->first();

        $payload['doc_id'] = $invoice->doc_id;
        $payload['number'] = $invoice->number;
        $payload['barcode'] = $invoice->barcode;

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload, $headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceMarkAreUpdatedCorrectly()
    {
        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = $this->newInvoiceMark();

        $invoice = Invoice::where('doc_id', '11YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9L')->first();

        $number  = $invoice->number;
        $barcode = $invoice->barcode;

        $response = $this->put('/api/v1/invoices/' . $invoice->id , $payload, $headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreListedCorrectly()
    {
        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->get('/api/v1/invoices', $headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['current_page' => 1])
            ->assertJsonFragment(['doc_id' => InvoiceTest::DOC_ID]);

    }
}
