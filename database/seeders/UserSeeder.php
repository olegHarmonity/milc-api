<?php

namespace Database\Seeders;

use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Database\Seeder;
use App\Models\Organisation;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            User::factory()
                ->create([
                    'email' => 'company_admin'.$i.'@milc.com',
                    'role' => UserRoles::$ROLE_COMPANY_ADMIN,
                    'organisation_id' => $i,
                ]);
        }
        
        $organisations = Organisation::all();
        
        foreach ($organisations as $key => $organisation){
            $organisation->organisation_owner_id = $key+1;
            $organisation->save();
        }
        
        User::factory()
            ->create([
                'email' => 'admin@milc.com',
                'role' => UserRoles::$ROLE_ADMIN,
            ]);

        for ($i = 1; $i <= 10; $i++) {
            User::factory()
                ->create([
                    'email' => 'user'.$i.'@milc.com',
                    'role' => UserRoles::$ROLE_USER,
                    'organisation_id' => rand(1,5),
                ]);
        }

    }
}
