<?php

namespace Tests\Feature\User;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

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
        ];

        $response = $this->put('/api/organisations/1', $data);

        $response->assertStatus(200);
    }

}
