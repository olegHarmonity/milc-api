<?php

namespace Database\Seeders;

use App\Models\MovieContentType;
use Illuminate\Database\Seeder;

class MovieContentTypeSeeder extends Seeder
{
    public function run()
    {
        $movieFormats = ["Live action film", "Documentary", "Animated movie", "Live action series", "Animated series"];

        foreach ($movieFormats as $movieFormat) {
            MovieContentType::factory()
                ->create([
                    'name' => $movieFormat,
                ]);
        }
    }
}
