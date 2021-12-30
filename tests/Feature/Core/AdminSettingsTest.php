<?php
namespace Tests\Feature\Core;

use Tests\ApiTestCase;

class AdminSettingsTest extends ApiTestCase
{
    public function test_post_admin_settings()
    {
        $this->loginAdmin();
        $data = [
            'iban' => 'DE89370400440532013000',
            'swift_bic' => 'DEUTDEMM760',
            'bank_name' => 'bank inc.'
        ];
        
       
        $response = $this->post('/api/admin-settings', $data);
        //$response->assertStatus(201);
    }
    
    public function test_put_admin_settings()
    {
        $this->loginAdmin();
        $data = [
            'iban' => 'DE89370400440532013000',
            'swift_bic' => 'DEUTDEMM760',
            'bank_name' => 'bank inc.',
        ];
        
        $response = $this->put('/api/admin-settings/1', $data);
        $response->assertStatus(200);
    }
    
    public function test_get_admin_settings()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/admin-settings/1');
        $response->assertStatus(200);
    }
}