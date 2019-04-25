<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

use App\Models\Order\Order;
use App\User;

class OrderTest extends TestCase
{
    const DOC_ID_UPD = '30a257bf-efe0-11e8-8ed6-0026832c8747'; //С13_111434
    const DOC_ID_ADD = '30a257c0-efe0-11e8-8ed6-0026832c8747';

    private $token;
    private $headers;

    public function setUp()
    {
        parent::setUp();

        $user = User::Where('email', '=', 'AdminApi@example.com')->first();
        $this->token = $user->generateToken();
        $this->headers = ['Authorization' => "Bearer $this->token"];
    }

    private function newOrder()
    {
        $date = Carbon::create('2018', '11', '24');

        $payload = [
            'date' => $date,
            'number' => 'С13_111435',
            'barcode' => 'C13111435',
            'doc_type' => '1',
            'doc_id' => OrderTest::DOC_ID_ADD,
            'lines' => [
                '1' => [
                    'line_id' => '1',
                    'product_descr' => 'Вино столовое полусладкое белое  \"ШАРДОНЕ\" САН МАРКО 1л/12',
                    'product_code' => '0123130000002476970',
                    'f2reg_id' => 'FB-000001309598232',
                    'quantity' => '2'
                ],
                '2' => [
                    'line_id' => '2',
                    'product_descr' => 'Водка ФИННОРД 0.1л./30',
                    'product_code' => '0037150000001399460',
                    'f2reg_id' => 'FB-000001309598237',
                    'quantity' => '15'
                ]
            ]
        ];

        return $payload;
    }

    public function testApiOrderStatus()
    {
        $response = $this->get('/api/v1/orders', $this->headers);
        $response->assertStatus(200);
    }

    public function testApiOrderAreCreatedCorrectly()
    {
        $payload = $this->newOrder();

        $number = $payload['number'];
        $barcode = $payload['barcode'];

        $response = $this->post('/api/v1/orders', $payload, $this->headers);
        $response->assertStatus(201)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiOrderAreUpdatedCorrectly()
    {
        $payload = $this->newOrder();

        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();
        $payload['doc_id'] = $order->doc_id;
        $payload['number'] = $order->number;
        $payload['barcode'] = $order->barcode;

        $number  = $order->number;
        $barcode = $order->barcode;

        $response = $this->post('/api/v1/orders/', $payload, $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['number' => $number, 'barcode' => $barcode]);
    }

    public function testApiOrderAreListedCorrectly()
    {
        $response = $this->get('/api/v1/orders', $this->headers);
        $response->assertStatus(200)
            ->assertJsonFragment(['current_page' => 1])
            ->assertJsonFragment(['doc_id' => OrderTest::DOC_ID_UPD]);

    }


    public function testOrderStatus()
    {
        $response = $this->get('/m/order');
        $response->assertStatus(200);
    }

    public function testOrderEditValidate()
    {
        $testUrl = '/m/order';

        $value = '';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'Заполните ШК'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка товара');


        $value = '113111434';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'Не найден заказ № ' . $value
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка товара');
    }

    public function testOrderEdit()
    {
        $value = 'C13111434';
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $response = $this->post('/m/order', ['BarCode' => $value]);
        $response->assertStatus(302);
        $response->assertRedirect('/m/order/edit/' . $order->id);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);
    }

    public function testOrderEditSubmitBarcodeValidate()
    {
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        $value = '';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'Заполните ШК'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);


        $value = '11';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'BarCode' => 'ШК минимум 9 символов'
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);

        //Ошибочный ШК которого нет в БД

        $value = '991100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'errorMessage' => 'Не найдена марка в БД ' . $value
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);

    }

    public function testOrderEditSubmitBarcodeDoubleClick()
    {
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        $value = '101100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';

        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);


        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $response->assertSessionHasErrors([
            'errorMessage' => 'Товар уже сканировался ' . $value
        ]);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);
    }

    public function testOrderEditSubmitBarcodeExist()
    {
        //С13_111434

        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        //$value = '201100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';
        $value = '301100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'errorMessage' => 'Товар уже сканировался ' . $value
        ]);

        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);



        $value = '201100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';

        $response = $this->from($testUrl)->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);

    }


    public function testOrderEditSubmitBarcodeBoxDoubleClick()
    {
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        $value = '02000000029510118000087245';

        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);


        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $response->assertSessionHasErrors([
            'errorMessage' => 'Ящик уже сканировался ' . $value
        ]);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);
    }

    public function testOrderEditSubmitBarcodePalletDoubleClick()
    {
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        $value = '03000000029510118000087245';

        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);

        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);
        $response->assertRedirect($testUrl);

        $response->assertSessionHasErrors([
            'errorMessage' => 'Паллет уже сканировался ' . $value
        ]);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Отгрузка № ' . $order->number);
    }

    public function testOrderEditSubmitBarcodePalletBoxExistClick()
    {
        $order = Order::where('doc_id', OrderTest::DOC_ID_UPD)->first();

        $testUrl = '/m/order/edit/' . $order->id;

        $value = '05000000029510118000087245';

        $response = $this->post($testUrl, ['BarCode' => $value, 'order_id' => $order->id]);
        $response->assertStatus(302);

        /*
        $response->assertRedirect($testUrl);

        $response->assertSessionHasErrors([
            'errorMessage' => 'Ящик в паллете уже сканировался 02000000029510118000087245'
        ]);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSee('Считайте штрихкод');
        */
    }

}
