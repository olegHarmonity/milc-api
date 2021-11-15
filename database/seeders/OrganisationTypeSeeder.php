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
            ->create([
                'name' => 'Distributor'
            ]);

        OrganisationType::factory()
            ->create([
                'name' => 'Production Company'
            ]);

        OrganisationType::factory()
            ->create([
                'name' => 'Sales Agent'
            ]);

        OrganisationType::factory()
            ->create([
                'name' => 'Other'
            ]);
    }
}
