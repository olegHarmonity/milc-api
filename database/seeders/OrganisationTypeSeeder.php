<?php

namespace Database\Seeders;

use App\Models\OrganisationType;
use Illuminate\Database\Seeder;

class OrganisationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganisationType::factory()
            ->count(1)
            ->create([
                'name' => 'Distributor'
            ]);

        OrganisationType::factory()
            ->count(1)
            ->create([
                'name' => 'Production Company'
            ]);

        OrganisationType::factory()
            ->count(1)
            ->create([
                'name' => 'Sales Agent'
            ]);

        OrganisationType::factory()
            ->count(1)
            ->create([
                'name' => 'Other'
            ]);
    }
}
