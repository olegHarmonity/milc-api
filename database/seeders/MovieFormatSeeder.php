<?php

namespace Database\Seeders;

use App\Models\MovieFormat;
use Illuminate\Database\Seeder;

class MovieFormatSeeder extends Seeder
{

    public function run()
    {
        $movieFormats = ["SD", "HD", "4K", "8K", "DCP", "BluRay"];

        foreach ($movieFormats as $movieFormat) {
            MovieFormat::factory()
                ->create([
                    'name' => $movieFormat,
                ]);
        }
    }
}
