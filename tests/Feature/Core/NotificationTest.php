<?php
namespace Tests\Feature\Core;

use App\Util\NotificationCategories;
use Tests\ApiTestCase;

class NotificationTest extends ApiTestCase
{
    public function test_post_notification_for_organisation()
    {
        $this->loginAdmin();
        $data = [
            'title' => 'notification title',
            'message' => 'notification message',
            'category' => NotificationCategories::$MESSAGE,
            'organisation_id' => 1,
        ];
        
        $response = $this->post('/api/notifications', $data);
        $response->assertStatus(201);
    }
    
    public function test_post_notification_for_admin()
    {
        $this->loginAdmin();
        $data = [
            'title' => 'notification title admin',
            'message' => 'notification message admin',
            'category' => NotificationCategories::$ORDER,
            'is_for_admin' => 1,
        ];
        
        $response = $this->post('/api/notifications', $data);
        $response->assertStatus(201);
    }
    
    public function test_mark_as_read_org_admin()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->put('/api/notifications/mark-as-read/21');
        $response->assertStatus(200);
    }
    
    public function test_mark_as_read_admin()
    {
        $this->loginAdmin();
        
        $response = $this->put('/api/notifications/mark-as-read/22');
        $response->assertStatus(200);
    }
    
    public function test_mark_all_as_read_org_admin()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/notifications/mark-all-as-read');
        $response->assertStatus(200);
    }
    
    public function test_get_notifications_admin()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/notifications');
        $response->assertStatus(200);
    }
    
    public function test_get_notifications_org_admin()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/notifications');
        $response->assertStatus(200);
    }
    
    public function test_get_notification_admin()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/notifications/22');

        $response->assertStatus(200);
    }
    
    public function test_get_notification_org_admin()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/notifications/21');
        $response->assertStatus(200);
    }
   
    public function test_delete_notification_admin()
    {
        $this->loginAdmin();
        
        $response = $this->delete('/api/notifications/22');
        $response->assertStatus(200);
    }
    
    public function test_get_unread_count()
    {
        $this->loginCompanyAdmin();
        
        $response = $this->get('/api/notifications/has-unread');
        $response->assertStatus(200);
    }
    
    
    public function test_get_unread_count_admin()
    {
        $this->loginAdmin();
        
        $response = $this->get('/api/notifications/has-unread');
        $response->assertStatus(200);
    }
}