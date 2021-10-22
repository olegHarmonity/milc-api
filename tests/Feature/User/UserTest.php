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

}
