<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOrderStatus()
    {
        $response = $this->get('/m/order');
        $response->assertStatus(200);
    }

    public function testOrderEdit()
    {
        $value = 'C13111434';

        $response = $this->post('/m/order/submitbarcode', ['BarCode' => $value]);
        $response->assertStatus(302);

        $response = $this->get('/m/order/edit?id=9');
        $response->assertStatus(200)->assertSee('Считайте штрихкод');



    }
}
