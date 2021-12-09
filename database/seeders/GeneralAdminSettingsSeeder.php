<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralAdminSettings;

class GeneralAdminSettingsSeeder extends Seeder
{
 
    public function run()
    {
        GeneralAdminSettings::factory()->create();
    }
}
