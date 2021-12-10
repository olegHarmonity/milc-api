<?php


namespace Tests;

use App\Models\User;

class ApiTestCase extends TestCase
{
    public function loginAdmin()
    {
        $user = User::where('email', 'admin@milc.com')->first();
        $this->actingAs($user, 'api');
    }

    public function loginCompanyAdmin()
    {
        $user = User::where('email', 'company_admin1@milc.com')->first();
        $this->actingAs($user, 'api');
    }
    
    public function loginCompanyAdmin2()
    {
        $user = User::where('email', 'company_admin2@milc.com')->first();
        $this->actingAs($user, 'api');
    }
    

    public function loginUser()
    {
        $user = User::where('email', 'user1@milc.com')->first();
        $this->actingAs($user, 'api');
    }
}
