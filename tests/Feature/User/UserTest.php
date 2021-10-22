<?php

namespace Tests\Feature\User;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

class UserTest extends ApiTestCase
{
    public function test_get_profile()
    {
        $this->loginUser();
        $response = $this->get('/api/me');

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->where('email', 'user1@milc.com')->etc());
    }

    public function test_register()
    {
        $data = [
            'email' => 'email@test.com',
            'first_name' => 'name',
            'last_name' => 'last name',
            'phone_number' => '782378239329832',
            'telephone_number' => '3178372',
            'job_title' => 'worker',
            'country' => 'DE',
            'city' => 'city',
            'address' => 'address',
            'postal_code' => '323232',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $data);
        $response->assertStatus(201);
    }
}
