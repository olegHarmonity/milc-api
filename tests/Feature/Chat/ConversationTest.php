<?php
namespace Tests\Feature\Chat;

use Tests\ApiTestCase;

class ConversationTest extends ApiTestCase
{
    public function test_post_conversation()
    {
        $this->loginCompanyAdmin();
        
        $data = [
            "message" => "test",
            "product_id" => 3
        ];
        $response = $this->post('/api/conversations', $data);
        $response->assertStatus(200);
    }

    public function test_get_conversations_archived()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/conversations?archived=true');
        $response->assertStatus(200);
    }
    
    public function test_get_conversations()
    {
        $this->loginCompanyAdmin();
     
        $response = $this->get('/api/conversations');
        $response->assertStatus(200);
    }
}

