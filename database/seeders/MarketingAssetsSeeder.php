<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\MarketingAssets;
use Illuminate\Database\Seeder;

class MarketingAssetsSeeder extends Seeder
{
    public function run()
    {
        MarketingAssets::factory()
            ->count(5)
            ->create();

        $images = Image::all();

        MarketingAssets::all()->each(function ($marketingAssets) use ($images) {
            $marketingAssets->production_images()->attach(
                $images->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
