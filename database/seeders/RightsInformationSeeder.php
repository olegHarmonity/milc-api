<?php

namespace Database\Seeders;

use App\Models\MovieRight;
use App\Models\RightsInformation;
use Illuminate\Database\Seeder;

class RightsInformationSeeder extends Seeder
{
    public function run()
    {
        RightsInformation::factory()
            ->count(5)
            ->create();


        $movieRights = MovieRight::all();

        RightsInformation::all()->each(function ($rightsInformation) use ($movieRights) {
            $rightsInformation->available_rights()->attach(
                $movieRights->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
