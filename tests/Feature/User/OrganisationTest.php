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

}
