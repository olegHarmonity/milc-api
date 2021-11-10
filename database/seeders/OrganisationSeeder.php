<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Prayer;
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
        for ($i = 1; $i <= 4; $i++) {
            if($i === 1){
                $organisation = Organisation::factory()
                    ->create([
                        'user_id' => $i,
                        'organisation_type_id' => $i,
                        'organisation_role' => CompanyRoles::$BOTH,
                    ]);
            }else{
                $organisation = Organisation::factory()
                    ->create([
                        'user_id' => $i,
                        'organisation_type_id' => $i,
                    ]);
            }


            $user = User::where('id',$i)->firstOrCreate();
            $user->organisation_id = $organisation->id;

            $user->save();
        }
    }
}
