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
        $response->assertStatus(200);
    }

    public function test_get_organisations()
    {
        $response = $this->get('/api/organisations');

        $response->assertStatus(200);
    }

    public function test_get_organisation()
    {
        $response = $this->get('/api/organisations/1');
        $response->assertStatus(200);
    }

    public function test_update_organisation()
    {
        $this->loginAdmin();

        $data = [
            'organisation_name' => 'changed name',
            'logo' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true),

            'vat_rules' => [
                [
                    'id' => 1,
                    'vat_id' => 1,
                    'organisation_id' => 1,
                    'rule_type' => 'domestic',
                    'country' => 'GB',
                    'vat' => [
                        'id' => 1,
                        'value' => 9
                    ]
                ],
                [
                    'id' => 3,
                    'vat_id' => 3,
                    'organisation_id' => 1,
                    'rule_type' => 'by_country',
                    'country' => 'DE',
                    'vat' => [
                        'id' => 3,
                        'value' => 21
                    ]
                ],
                [
                    'vat_id' => 3,
                    'organisation_id' => 1,
                    'rule_type' => 'by_country',
                    'country' => 'AU',
                    'vat' => [
                        'value' => 25
                    ]
                ]
            ]
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
            'emails' => [
                'email1@email.com',
                'email2@email.com'
            ],
            'message' => 'email message'
        ];
        $response = $this->post('/api/send-email', $data);
        $response->assertStatus(200);
    }
}
