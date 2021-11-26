<?php

namespace Tests\Feature\User;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Illuminate\Http\UploadedFile;

class OrganisationTest extends ApiTestCase
{
    public function test_get_org_types()
    {
        $response = $this->get('/api/organisation-types');
        $response
            ->assertStatus(200);
    }

    public function test_get_organisations()
    {
        $response = $this->get('/api/organisations');

        $response
            ->assertStatus(200);
    }

    public function test_update_organisation()
    {
        $this->loginAdmin();

        $data = [
            'organisation_name' => 'changed name',
            'logo' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true)
        ];
        $response = $this->put('/api/organisations/1', $data);

        $response->assertStatus(200);
    }
    
    public function test_get_organisations_by_status()
    {
        $response = $this->get('/api/organisations?exact_search[status]=declined');
        $response->assertStatus(200);
    }
    
    public function test_update_organisation_status()
    {
        $this->loginAdmin();
        
        $data = [
            'status' => 'declined'
        ];
        
        $response = $this->put('/api/organisations/change-status/1', $data);
        $response->assertStatus(200);
    }
    
    public function test_send_email()
    {
        $this->loginAdmin();
        
        $data = [
            'emails' => ["email1@email.com", "email2@email.com"],
            'message' => "email message"
        ];
        $response = $this->post('/api/send-email', $data);
        $response->assertStatus(200);
    }

}
