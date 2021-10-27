<?php

namespace Tests\Feature\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

class UserTest extends ApiTestCase
{
    public function test_get_profile()
    {
        $this->loginCompanyAdmin();
        $response = $this->get('/api/me');

        $response
            ->assertStatus(200);
           // ->assertJson(fn(AssertableJson $json) => $json->where('email', 'company_admin1@milc.com')->etc());
    }

    public function test_email_exists()
    {
        $response = $this->get('/api/email-exists?email=admin3@milc.com');

        $response
            ->assertStatus(200);
    }

    public function test_register()
    {
        $email = 'email'.rand(1,1000).'@test.com';
        $data = [
            'email' => $email,
            'first_name' => 'name',
            'last_name' => 'last name',
            'phone_number' => '782378239329832',
            'job_title' => 'worker',
            'country' => 'DE',
            'city' => 'city',
            'address' => 'address',
            'postal_code' => '323232',
            'password' => 'password',
            'password_confirmation' => 'password',
            'organisation' => [
                'organisation_name' => 'organisation',
                'registration_number' => '783823292',
                'phone_number' => '782378239329832',
                'telephone_number' => '3178372',
                'organisation_role' => 'buyer',
                'description' => 'organisation',
                'website_link' => 'www.website.com',
                'social_links' => [["network" => "facebook","value" => "www.facebook.com/organisation"],["network" => "twitter","value" => "www.twitter.com/organisation"]],
                'organisation_type_id' => 1,
                'logo' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true),
            ]
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(201);

        $data = [
            'email' => $email,
            'password' => 'password'
        ];

        $response = $this->post('/api/auth/login', $data);
        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('access_token')->etc());

    }
}
