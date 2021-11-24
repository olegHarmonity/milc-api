<?php

namespace Tests\Feature\User;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

class AuthTest extends ApiTestCase
{
    public function test_login()
    {
        $data = [
            'email' => 'admin@milc.com',
            'password' => 'password'
        ];

        $response = $this->post('/api/auth/login', $data);

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('access_token')->etc());
    }

    public function test_refresh_token()
    {
        $data = [
            'email' => 'user1@milc.com',
            'password' => 'password'
        ];

        $loginResponse = $this->post('/api/auth/login', $data);

        $responseData = json_decode($loginResponse->getContent());

        $token = $responseData->access_token;
        $data = [
            'access_token' => $token,
        ];

        $response = $this->post('/api/auth/refresh',$data);

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('access_token')->etc());
    }

    public function test_logout()
    {
        $data = [
            'email' => 'admin@milc.com',
            'password' => 'password'
        ];

        $this->post('/api/auth/login', $data);

        $response = $this->post('/api/auth/logout');

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'Successfully logged out'));
    }
    
    
    public function test_resend_verification()
    {
        $response = $this->get('/api/auth/resend-verification-email/admin@milc.com');
        $response
        ->assertStatus(200);
    }
}
