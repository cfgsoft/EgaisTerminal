<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    public function testApiAuthRequiresEmailAndLogin()
    {
        $headers = ['Accept' => 'application/json'];

        $response = $this->post('/api/auth/login',[], $headers);
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email'=> ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);

        //$response = $this->post('/api/auth/register');
        //$response->assertStatus(200);

        //logout
    }

    public function testApiAuthUserLoginsSuccessfully()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload = ['email' => 'AdminApi@example.com', 'password' => 'secret'];

        $response = $this->post('/api/auth/login', $payload, $headers);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);

    }

}
