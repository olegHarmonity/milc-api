<?php
namespace Tests\Feature\Payment;

use Tests\ApiTestCase;

class PaymentTest extends ApiTestCase
{
    public function test_pay_with_stripe()
    {
        $this->loginCompanyAdmin();
        
        $data =  [
            "number" => "4242424242424242",
            "cvc" => "123",
            "exp_month" => 9,
            "exp_year" => 25
        ];
        
        $response = $this->put('/api/orders/pay-stripe/1', $data);
        
        dump(json_decode($response->getContent()));
        $response->assertStatus(200);
    }
    
}

