<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadBarCodeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGet()
    {
        $response = $this->get('/m/readbarcode');
        $response->assertStatus(200);
    }

    public function testPostBarCode()
    {
        //$this->withoutMiddleware();

        //$this->app['env'] local

        $value = str_random(40);

        $response = $this->post('/m/readbarcode/submitbarcode',['BarCode' => $value]);
        $response->assertStatus(201);

        //$response = $this->get('/m/readbarcode');
        //$response->assertStatus(200)->assertSee($value);

        $this->assertDatabaseHas('read_bar_codes', ['barcode' => $value]);
    }

}
