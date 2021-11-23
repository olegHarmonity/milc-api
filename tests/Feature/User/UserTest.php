<?php
namespace Tests\Feature\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use App\Util\UserRoles;

class UserTest extends ApiTestCase
{
    public function test_update_user_company_admin()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true)
        ];
        
        $response = $this->put('/api/users/1', $data);
        
        $response->assertStatus(200);
    }
    
    public function test_get_users()
    {
        $this->loginAdmin();
        $response = $this->get('/api/users');  
        
        $response->assertStatus(200);
    }
    
    public function test_get_users_company_admin()
    {
        $this->loginCompanyAdmin();
        $response = $this->get('/api/users');
        
        $response->assertStatus(200);
    }

    public function test_get_profile()
    {
        $this->loginCompanyAdmin();
        $response = $this->get('/api/me');

        $response->assertStatus(200);
        // ->assertJson(fn(AssertableJson $json) => $json->where('email', 'company_admin1@milc.com')->etc());
    }

    public function test_email_exists()
    {
        $response = $this->get('/api/email-exists?email=admin3@milc.com');

        $response->assertStatus(200);
    }
    
    public function test_forgot_password()
    {
        $data = [
            'email' => 'admin@milc.com'
        ];
        $response = $this->post('/api/forgot-password', $data);
        $response->assertStatus(200);
    }

    public function test_forgot_password_nonexisting_email()
    {
        $data = [
            'email' => 'admieweewn@milc.com'
        ];
        $response = $this->post('/api/forgot-password', $data);
        $response->assertStatus(404);
    }

    /*
     * public function test_reset_password()
     * {
     * $data = [
     * 'token' => '434c8cea0eb8bc1376c798e5f6af03983ccece733e669f553bd4ee6493238d01',
     * 'email' => 'admin3@milc.com',
     * 'password' => 'pass123456',
     * 'password_confirmation' => 'pass123456'
     * ];
     *
     * $response = $this->post('/api/reset-password', $data);
     *
     * $response
     * ->assertStatus(200);
     * }
     */
    public function test_register()
    {
        $email = 'email' . rand(1, 1000) . '@test.com';
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
            'password' => 'password77777',
            'password_confirmation' => 'password77777',
            'organisation' => [
                'email' => $email,
                'organisation_name' => 'organisation',
                'registration_number' => '783823292',
                'phone_number' => '782378239329832',
                'telephone_number' => '3178372',
                'organisation_role' => 'buyer',
                'description' => 'organisation',
                'website_link' => 'www.website.com',
                'country' => 'DE',
                'social_links' => [
                    [
                        "network" => "facebook",
                        "value" => "www.facebook.com/organisation"
                    ],
                    [
                        "network" => "twitter",
                        "value" => "www.twitter.com/organisation"
                    ]
                ],
                'organisation_type_id' => 1,
                'logo' => new UploadedFile(resource_path('test-files/image_png.PNG'), 'image_png.PNG', null, null, true)
            ]
        ];

        $response = $this->post('/api/register', $data);
        $response->assertStatus(201);
        $data = [
            'email' => $email,
            'password' => 'password77777'
        ];

        $response = $this->post('/api/auth/login', $data);
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) => $json->has('access_token')
            ->etc());
    }

    public function test_update_user()
    {
        $this->loginCompanyAdmin();

        $data = [
            'first_name' => 'changed name',
            'last_name' => 'changedlast name',
        ];

        $response = $this->put('/api/users/1', $data);

        $response->assertStatus(200);
    }    
    
    public function test_update_user_with_image()
    {
        $this->loginAdmin();
        
        $data = [
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true)
        ];
        
        $response = $this->put('/api/users/2', $data);
        
        $response->assertStatus(200);
    }
    

    public function test_update_user_unauthorized()
    {
        $data = [
            'first_name' => 'changed name',
            'last_name' => 'changedlast name'
        ];

        $response = $this->put('/api/users/2', $data);

        $response->assertStatus(302);
    }

    public function test_change_password()
    {
        $this->loginAdmin();

        $data = [
            'old_password' => 'password',
            'new_password' => 'zuwegcbzw782',
            'password_confirmation' => 'zuwegcbzw782'
        ];

        $response = $this->post('/api/change-password', $data);

        $response->assertStatus(200);
    }
}
