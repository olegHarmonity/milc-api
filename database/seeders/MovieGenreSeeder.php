<?php

namespace Database\Seeders;

use App\Models\MovieGenre;
use Illuminate\Database\Seeder;

class MovieGenreSeeder extends Seeder
{
    public function run()
    {
        $movieGenres = ["Action", "Adventure", "Comedy", "Crime", "Fantasy", "History",
                        "Horror", "Romance", "Science fcistion", "Thriller",];

        foreach ($movieGenres as $movieGenre) {
            MovieGenre::factory()
                ->create([
                    'name' => $movieGenre,
                ]);
        }
    }
}
