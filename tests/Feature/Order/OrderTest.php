<?php
namespace Tests\Feature\Order;

use Tests\ApiTestCase;

class OrderTest extends ApiTestCase
{
    public function test_post_new_order()
    {
        $this->loginAdmin();
        
        $data = [
            'rights_bundle_id' => 1,
        ];
        
        $response = $this->post('/api/orders', $data);
        
         dump(($response));
         dump(json_decode($response->getContent()));
        $response->assertStatus(201);
    }
    
    
}

