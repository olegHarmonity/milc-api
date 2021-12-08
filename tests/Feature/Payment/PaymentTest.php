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
        
        $response = $this->put('/api/checkout/pay-stripe/123-ABC', $data);
        
        $response->assertStatus(200);
    }
    
    
    public function test_start_pay_with_paypal()
    {
        $this->loginCompanyAdmin();
        
        $data =  [];
        
        $response = $this->put('/api/checkout/pay-paypal/123-ABD', $data);

        $response->assertStatus(200);
    }
    
    public function test_paypal_success_page()
    {
        $this->loginCompanyAdmin();
        
        $data =  [];
        
        $response = $this->get('/payment-success/123-ABD', $data);
        $response->assertStatus(302);
    }
    
    public function test_paypal_fail_page()
    {
        $this->loginCompanyAdmin();
        
        $data =  [];
        
        $response = $this->get('/payment-error/123-ABD', $data);
        $response->assertStatus(302);
    }
    
    
}

