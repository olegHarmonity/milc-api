<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ImageSeeder::class,
            VideoSeeder::class,
            AudioSeeder::class,
            FileSeeder::class,
            OrganisationTypeSeeder::class,
            OrganisationSeeder::class,
            PersonSeeder::class,
            MovieFormatSeeder::class,
            MovieGenreSeeder::class,
            MovieRightSeeder::class,
            MovieContentTypeSeeder::class,
            ProductionInfoSeeder::class,
            RightsInformationSeeder::class,
            MarketingAssetsSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
