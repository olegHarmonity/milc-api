<?php
namespace Tests\Feature\Order;

use Tests\ApiTestCase;

class OrderTest extends ApiTestCase
{
    public function test_post_new_order()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'rights_bundle_id' => 1,
        ];
        
        $response = $this->post('/api/orders', $data);
        
        $response->assertStatus(201);
    }
    
    public function test_get_orders(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/orders');
        
        $response->assertStatus(200);
    }
    
    
}

