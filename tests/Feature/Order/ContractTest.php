<?php
namespace Tests\Feature\Order;

use Tests\ApiTestCase;

class ContractTest extends ApiTestCase
{
    public function test_get_admin_default_contract()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/contracts/admin-default');
        
        $response->assertStatus(200);
    }
    
    public function test_get_company_admin_default_contract()
    {
        $this->loginCompanyAdmin();
        $response = $this->get('/api/contracts/organisation-default');
        
        $response->assertStatus(200);
    }
    
    public function test_edit_admin_default_contract()
    {
        $this->loginAdmin();
        
        $data = [
            'contract_text_part_2' => "blabla admin"
        ];
        
        $response = $this->put('/api/contracts/admin-default',$data);
        
        $response->assertStatus(200);
    }
    
    public function test_edit_company_admin_default_contract()
    {
        $this->loginCompanyAdmin2();
        
        $data = [
            'contract_text' => "blabla company_admin",
            'contract_appendix' => "appendix company_admin",
        ];
        
        $response = $this->put('/api/contracts/organisation-default',$data);
        
        $response->assertStatus(200);
    }
    
    
    public function test_get_admin_all_contracts()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/contracts');
        
        $response->assertStatus(200);
    }
    
    public function test_get_company_admin_all_contracts()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/contracts');
        $response->assertStatus(200);
    }
    
    
    public function test_get_admin_single_contract()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/contracts/1');
        $response->assertStatus(200);
    }
    
    public function test_get_company_admin_single_contract()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/contracts/2');

        $response->assertStatus(200);
    }
}

