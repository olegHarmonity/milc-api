<?php
namespace Tests\Feature\Order;

use App\Models\Order;
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
        
        $order = Order::where('id', '=', 1)->first();
        $order->order_number='123-ABC';
        $order->save();
    }
    
    public function test_post_new_order_2()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'rights_bundle_id' => 2,
        ];
        
        $response = $this->post('/api/orders', $data);
        
        $response->assertStatus(201);
        
        $order = Order::where('id', '=', 2)->first();
        $order->order_number='123-ABD';
        $order->save();
    }
    
    public function test_order_change_currency()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'pay_in_currency' => 'GBP',
        ];
        
        $response = $this->put('/api/checkout/change-currency/123-ABC', $data);

        $response->assertStatus(200);
    }
    
    public function test_order_change_contract()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            'accept_contract' => true,
        ];
        
        $response = $this->put('/api/checkout/update-contract/123-ABC', $data);
        $response = $this->put('/api/checkout/update-contract/123-ABD', $data);

        $response->assertStatus(200);
    }
    
    public function test_get_orders(){
        
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/orders');

        $response->assertStatus(200);
    }
    
    public function test_get_checkout_single(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/checkout/123-ABC');
        
        $response->assertStatus(200);
    }
    
    public function test_get_order_single(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/orders/1');
        
        $response->assertStatus(200);
    }
}

