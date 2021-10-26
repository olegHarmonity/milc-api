<?php

namespace Database\Seeders;

use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 4; $i++) {
            User::factory()
                ->create([
                    'email' => 'company_admin'.$i.'@milc.com',
                    'role' => UserRoles::$ROLE_COMPANY_ADMIN,
                ]);
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
                ]);
        }

    }
}
