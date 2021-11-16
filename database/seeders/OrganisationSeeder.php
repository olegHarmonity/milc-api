<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use App\Util\CompanyRoles;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            if($i === 1){
                $organisation = Organisation::factory()
                    ->create([
                        'organisation_role' => CompanyRoles::$BOTH,
                    ]);
            }else{
                $organisation = Organisation::factory()
                    ->create();
            }

        }
    }
}
