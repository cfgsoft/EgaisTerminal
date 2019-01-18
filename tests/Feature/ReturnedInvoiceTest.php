<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReturnedInvoiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReturnedInvoiceStatus()
    {
        $response = $this->get('/m/returnedinvoice');
        $response->assertStatus(200);
    }

    public function testReturnedInvoiceEdit()
    {
        $value = 'C13004315';

        $response = $this->post('/m/returnedinvoice/submitbarcode', ['BarCode' => $value]);
        $response->assertStatus(302);

        $response = $this->get('/m/returnedinvoice/edit?id=1');
        $response->assertStatus(200)->assertSee('Считайте штрихкод');
    }

    public function testReturnedInvoiceSubmitEditBarcode()
    {
        $value = '111100261679680118001D5CCFC794963898C1B13E41231CKY42T7UDIJJY2AWLHS7HPGINLMY7PQPDNJALVS42WNCHYRCO257SPCSCF4ASM37BZNTLIASYRVGFUTCXDXDJPML5MMVLEEHZWPWJVI';

        $response = $this->post('/m/returnedinvoice/submiteditbarcode', ['BarCode' => $value, 'returned_invoice_id' => 1]);
        $response->assertStatus(302);

        $response = $this->get('/m/returnedinvoice/edit?id=1');
        $response->assertStatus(200)->assertSee('Считайте штрихкод');
    }
}
