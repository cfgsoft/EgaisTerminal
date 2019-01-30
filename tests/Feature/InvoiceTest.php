<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

class InvoiceTest extends TestCase
{
    private function newInvoice()
    {
        $date = Carbon::now();
        $number = str_random(11);
        $barcode = str_random(12);
        $doc_id = 'YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9LQa';

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

        //if (array_key_exists('packlines', $payload)) {
        //    echo "Массив содержит элемент 'packlines'.";
        //}

        return $payload;
    }

    public function testApiInvoiceStatus()
    {
        $response = $this->get('/api/v1/invoices');
        $response->assertStatus(200);
    }

    public function testApiInvoiceAreCreatedCorrectly()
    {
        //https://softobzor.com.ua/laravel-restful-api-testirovanie/

        //$user = factory(User::class)->create();
        //$token = $user->generateToken();
        //$headers = ['Authorization' => "Bearer $token"];

        $payload = $this->newInvoice();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreUpdatedCorrectly()
    {
        //https://softobzor.com.ua/laravel-restful-api-testirovanie/

        $payload = $this->newInvoice();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/invoices', $payload);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiInvoiceAreListedCorrectly()
    {
        $response = $this->get('/api/v1/invoices');
        $response->assertStatus(200)
            ->assertJsonFragment(['current_page' => 1])
            ->assertJsonFragment(['doc_id' => 'YTD2B2BLqXhCAEdltKSio2lhsfPWB95I9LQa']);

    }
}
