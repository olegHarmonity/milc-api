<?php

namespace Database\Seeders;

use App\Models\MovieRight;
use Illuminate\Database\Seeder;

class MovieRightSeeder extends Seeder
{
    public function run()
    {
        $movieRights = ["Theatrical", "PayTV", "FreeTV", "SVOD", "Airline"];

        foreach ($movieRights as $movieRight) {
            MovieRight::factory()
                ->create([
                    'name' => $movieRight,
                ]);
        }
    }
}
