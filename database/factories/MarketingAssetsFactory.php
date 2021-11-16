<?php

namespace Database\Factories;

use App\Models\MarketingAssets;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketingAssetsFactory extends Factory
{
    protected $model = MarketingAssets::class;

    public function definition()
    {
        return [
            'key_artwork_id' => rand(1, 10),
            'copyright_information' => $this->faker->text(20),
            'links' => [
                $this->faker->url(), $this->faker->url(),
            ],
        ];
    }
}
