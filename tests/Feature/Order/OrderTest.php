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
    
    public function test_order_change_currency()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'pay_in_currency' => 'GBP',
        ];
        
        $response = $this->put('/api/orders/change-currency/1', $data);

        $response->assertStatus(200);
    }
    
    public function test_order_change_contract()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'accept_contract' => true,
        ];
        
        $response = $this->put('/api/orders/update-contract/1', $data);

        $response->assertStatus(200);
    }
    
    public function test_get_orders(){
        
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/orders');
        
        $response->assertStatus(200);
    }
    
    public function test_get_order_single(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/orders/1');
        
        $response->assertStatus(200);
    }
    
    
    
}

