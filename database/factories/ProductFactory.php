<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\MarketingAssets;
use App\Models\Product;
use App\Models\ProductionInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    { 
        $productionInfo = ProductionInfo::factory()->create()->id;
        
        $marketingAssets = MarketingAssets::factory()->create();
        
        $images = Image::all();
        
            $marketingAssets->production_images()->attach(
                $images->random(rand(1, 3))->pluck('id')->toArray()
                );
        
        return [
            'organisation_id' => $this->faker->numberBetween(1, 5),
            'production_info_id' => $productionInfo,
            'marketing_assets_id' => $marketingAssets->id,
            'content_type_id' => $this->faker->numberBetween(1, 5),
            'movie_id' => $this->faker->numberBetween(1, 5),
            'screener_id' => $this->faker->numberBetween(1, 5),
            'trailer_id' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->word() . " " . $this->faker->jobTitle() . " " . $this->faker->word(),
            'alternative_title' => $this->faker->jobTitle() . " " . $this->faker->word() . " " . $this->faker->word(),
            'runtime' => $this->faker->numberBetween(120, 240),
            'synopsis' => $this->faker->text(200),
            'keywords' => [
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word(),
            ],
            'original_language' => $this->faker->languageCode(),
            'dubbing_languages' => [
                $this->faker->languageCode(),
                $this->faker->languageCode(),
            ],
            'subtitle_languages' => [
                $this->faker->languageCode(),
                $this->faker->languageCode(),
                $this->faker->languageCode(),
            ],
            'links' => [
                "website" => $this->faker->url(),
                "facebook" => $this->faker->url(),
                "twitter" => $this->faker->url(),
                "linkedin" => $this->faker->url(),
            ],
            'allow_requests' => $this->faker->boolean(),
        ];
    }
}
