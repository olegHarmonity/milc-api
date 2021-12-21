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
        for ($i = 1; $i <= 5; $i ++) {
            if ($i === 1) {
                $organisation = Organisation::factory()->create([
                    'organisation_role' => CompanyRoles::$BOTH
                ]);
            } elseif ($i === 5) {
                $organisation = Organisation::factory()->create([
                    'organisation_role' => CompanyRoles::$BOTH,
                    'address' => null,
                    'postal_code' => null,
                    'iban' => null
                ]);
            } else {
                $organisation = Organisation::factory()->create();
            }
        }
    }
}
