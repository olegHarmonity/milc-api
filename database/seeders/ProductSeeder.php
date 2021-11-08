<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\File;
use App\Models\MovieFormat;
use App\Models\Product;
use App\Models\RightsInformation;
use App\Models\Video;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()
            ->count(5)
            ->create();

        $dubFiles = Audio::all();
        $subtitles = File::all();
        $promotionalVideos = Video::all();
        $rightsInformation = RightsInformation::all();
        $availableFormats = MovieFormat::all();

        Product::all()->each(function ($products) use ($dubFiles, $subtitles, $promotionalVideos, $rightsInformation, $availableFormats) {
            $products->dub_files()->attach(
                $dubFiles->random(rand(1, 3))->pluck('id')->toArray()
            );

            $products->subtitles()->attach(
                $subtitles->random(rand(1, 3))->pluck('id')->toArray()
            );

            $products->promotional_videos()->attach(
                $promotionalVideos->random(rand(1, 3))->pluck('id')->toArray()
            );

            $products->rights_information()->attach(
                $rightsInformation->random(rand(1, 3))->pluck('id')->toArray()
            );

            $products->available_formats()->attach(
                $availableFormats->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
