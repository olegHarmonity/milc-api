<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\File;
use App\Models\MovieFormat;
use App\Models\MovieGenre;
use App\Models\Product;
use App\Models\RightsInformation;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Database\Factories\RightsInformationFactory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()
            ->create([
                'organisation_id' => 1,
                'movie_id' => 1,
                'screener_id' => 1,
                'trailer_id' => 1,
            ]);

        Product::factory()
            ->count(4)
            ->create();

        $dubFiles = Audio::all();
        $subtitles = File::all();
        $promotionalVideos = Video::all();
        
        $rightsInformation = RightsInformation::factory()
            ->create();
        
        $availableFormats = MovieFormat::all();
        $genres = MovieGenre::all();

        $firstProduct = Product::where('id', 1)->firstOrFail();

        $firstProduct->dub_files()->attach([1]);

        $firstProduct->subtitles()->attach([1]);

        $firstProduct->promotional_videos()->attach([1]);

        $firstProduct->rights_information()->attach($rightsInformation->id);

        $firstProduct->available_formats()->attach([1]);

        $firstProduct->genres()->attach([1]);

        $firstProduct->save();

        Product::where('id', '!=', 1)->each(function ($products) use (
            $dubFiles,
            $subtitles,
            $promotionalVideos,
            $rightsInformation,
            $availableFormats,
            $genres
        ) {
            
            $rightsInformation = RightsInformation::factory()
                                ->create();
            
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
                [$rightsInformation->id]
            );

            $products->available_formats()->attach(
                $availableFormats->random(rand(1, 3))->pluck('id')->toArray()
            );

            $products->genres()->attach(
                $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
