<?php
namespace Tests\Feature\Core;

use Tests\ApiTestCase;

class MoneyTest extends ApiTestCase
{
    public function test_get_currency_exchange()
    {
        $this->loginCompanyAdmin();
        $data = [
            'from_currency' => 'EUR',
            'to_currency' => 'GBP',
            'amount' => 100.10,
        ];
        
        $response = $this->post('/api/exchange-currency', $data);
        
        $response->assertStatus(200);
    }
}