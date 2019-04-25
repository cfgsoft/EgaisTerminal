<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

use App\Models\ReturnedInvoice\ReturnedInvoice;
use App\User;

class ReturnedInvoiceTest extends TestCase
{
    const DOC_ID = 'YTD3B2BLqXhCAEdltKSio2lhsfPWB95I9LQa';
    const DOC_ID_PACK = '30a257bf-efe0-11e8-8ed6-0026832c8748'; //С13_000001

    private $token;
    private $headers;

    public function setUp()
    {
        parent::setUp();

        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $this->token = $user->generateToken();
        $this->headers = ['Authorization' => "Bearer $this->token"];
    }

    public function newReturnedInvoice()
    {
        $date = Carbon::now();
        $number = str_random(11);
        $barcode = str_random(12);

        $payload = [
            'date' => $date,
            'number' => $number,
            'barcode' => $barcode,
            'doc_type' => '4',
            'doc_id' => ReturnedInvoiceTest::DOC_ID,
            'lines' => [
                '1' => [
                    'line_id' => '1',
                    'product_descr' => 'товар',
                    'product_code' => '111111',
                    'f1reg_id' => '1111',
                    'f2reg_id' => '22222',
                    'quantity' => '10'
                ],
                '2' => [
                    'line_id' => '2',
                    'product_descr' => 'товар',
                    'product_code' => '111111',
                    'f1reg_id' => '1111',
                    'f2reg_id' => '3333',
                    'quantity' => '5'
                ]
            ]
        ];

        return $payload;
    }

    public function testApiReturnedInvoiceStatus()
    {
        $response = $this->get('/api/v1/returnedinvoices', $this->headers);
        $response->assertStatus(200);
    }

    public function testApiReturnedInvoiceAreCreatedCorrectly()
    {
        $payload = $this->newReturnedInvoice();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/returnedinvoices', $payload, $this->headers);
        $response->assertStatus(201)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiReturnedInvoiceAreUpdatedCorrectly()
    {
        $payload = $this->newReturnedInvoice();

        $returnedInvoice = ReturnedInvoice::where('doc_id', '114TD2B2BLqXhCAEdltKSio2lhsfPWB95I9L')->first();
        $payload['doc_id'] = $returnedInvoice->doc_id;
        $payload['number'] = $returnedInvoice->number;
        $payload['barcode'] = $returnedInvoice->barcode;

        $number  = $returnedInvoice->number;
        $barcode = $returnedInvoice->barcode;

        $response = $this->post('/api/v1/returnedinvoices/', $payload, $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiReturnedInvoiceAreListedCorrectly()
    {
        $response = $this->get('/api/v1/returnedinvoices', $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['current_page' => 1])
            ->assertJsonFragment(['doc_id' => ReturnedInvoiceTest::DOC_ID]);

    }



    public function from(string $url)
    {
        $this->app['session']->setPreviousUrl($url);

        return $this;
    }

    public function testReturnedInvoiceStatus()
    {
        $response = $this->get('/m/returnedinvoice');
        $response->assertStatus(200);
    }

    public function testReturnedInvoiceEditValidate()
    {
        //https://www.neontsunami.com/posts/testing-the-redirect-url-in-laravel
        //$response = $this->from('/comments/create')->post('/comments', []);
        //$response->assertRedirect('/comments/create');

        $testUrl = '/m/returnedinvoice';

        $value = '';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'Заполните ШК'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат от покупателя');


        $value = '11';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'ШК минимум 9 символов'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат от покупателя');



        $value = '1111111111111111111111111111111111111111111111';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'ШК максимум 12 символов'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат от покупателя');
    }

    public function testReturnedInvoiceEditSuccess()
    {
        $value = '111111111';
        $returnedInvoice = ReturnedInvoice::where('doc_id', '114TD2B2BLqXhCAEdltKSio2lhsfPWB95I9L')->first();

        $response = $this->post('/m/returnedinvoice', ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertRedirect('/m/returnedinvoice/edit/' . $returnedInvoice->id);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат № ' . $returnedInvoice->number);
    }

    /*
    public function testReturnedInvoiceEditSubmitBarcode()
    {
        $value = '111100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';
        $returnedInvoice = ReturnedInvoice::where('doc_id', '114TD2B2BLqXhCAEdltKSio2lhsfPWB95I9L')->first();

        $response = $this->post('/m/returnedinvoice/edit/' . $returnedInvoice->id, ['BarCode' => $value, 'returned_invoice_id' => $returnedInvoice->id]);
        $response->assertStatus(302);
        //$response->assertRedirect('/m/returnedinvoice/edit/' . $returnedInvoice->id);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Считайте штрихкод');
    }
    */


    public function testReturnedInvoiceEditSubmitBarcodeBoxDoubleClick()
    {
        $returnedInvoice = ReturnedInvoice::where('doc_id', ReturnedInvoiceTest::DOC_ID_PACK)->first();

        $testUrl = '/m/returnedinvoice/edit/' . $returnedInvoice->id;

        $value = '02000000029510118000087245';

        $response = $this->post($testUrl, ['BarCode' => $value, 'returned_invoice_id' => $returnedInvoice->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат № ' . $returnedInvoice->number);


        $response = $this->post($testUrl, ['BarCode' => $value, 'returned_invoice_id' => $returnedInvoice->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $response->assertSessionHasErrors([
            'errorMessage' => 'Ящик уже сканировался ' . $value
        ]);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Возврат № ' . $returnedInvoice->number);

    }
}
