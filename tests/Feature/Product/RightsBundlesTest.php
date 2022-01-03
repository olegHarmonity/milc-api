<?php
namespace Tests\Feature\Product;

use Tests\ApiTestCase;

class RightsBundlesTest extends ApiTestCase
{

    public function test_post_rights_bundles()
    {
        $this->loginCompanyAdmin();

        $data = [
            'price' => [
                'value' => 1000.23,
                'currency' => 'EUR'
            ],
            'rights_information' => [
                1,
                2
            ],
            'buyer_id' => 2,
            'product_id' => 1,
        ];

        $response = $this->post('/api/rights-bundles', $data);
        $response->assertStatus(201);
    }
}

