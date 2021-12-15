<?php
namespace Tests\Feature\Order;

use App\Models\Order;
use Tests\ApiTestCase;
use App\Util\CartStates;
use App\Models\Contract;

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
        $this->loginCompanyAdmin2();
        
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
        
        $this->loginCompanyAdmin2();
        $response = $this->put('/api/checkout/update-contract/123-ABD', $data);

        $response->assertStatus(200);
    }
    
    public function test_get_orders(){
        
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/orders');

        $response->assertStatus(200);
    }
    
    public function test_get_orders_admin(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/orders');
        
        $response->assertStatus(200);
    }
    
    public function test_get_checkout_single(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/checkout/123-ABC');
        $response->assertStatus(200);
    }
    
    public function test_get_contract_single(){
        
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/checkout/contract/123-ABC');

        $response->assertStatus(200);
    }
    
    public function test_get_order_single(){
        
        $this->loginAdmin();
        
        $response = $this->get('/api/orders/1');
        $response->assertStatus(200);
    }
    
    
    public function test_order_positive_flow()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->put('/api/checkout/pay-bank-transfer/123-ABC');
        $response->assertStatus(200);
        
        $response = $this->put('/api/checkout/mark-paid/123-ABC');
        $response->assertStatus(200);
        
        $response = $this->put('/api/checkout/mark-assets-sent/123-ABC');
        $response->assertStatus(200);
        
        $response = $this->put('/api/checkout/mark-assets-received/123-ABC');
      
        $response->assertStatus(200);
        
        $response = $this->put('/api/checkout/mark-completed/123-ABC');
        $response->assertStatus(200);
        
        $order = Order::where('id', '=', 1)->first();
        $order->state= CartStates::$CONTRACT_ACCEPTED;
        $order->save();
    }
    
    
    public function test_order_negative_flow()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->put('/api/checkout/mark-rejected/123-ABC');
        $response->assertStatus(200);
        
        $order = Order::where('id', '=', 1)->first();
        $order->state= CartStates::$PAID;
        $order->save();
        
        $response = $this->put('/api/checkout/mark-refunded/123-ABC');
        $response->assertStatus(200);
        
        $order = Order::where('id', '=', 1)->first();
        $order->state= CartStates::$CONTRACT_ACCEPTED;
        $order->save();
        
        $response = $this->put('/api/checkout/mark-cancelled/123-ABC');
        $response->assertStatus(200);
        
        $order = Order::where('id', '=', 1)->first();
        $order->state= CartStates::$CONTRACT_ACCEPTED;
        $order->save();
    }
}

