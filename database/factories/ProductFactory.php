<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'organisation_id' => $this->faker->numberBetween(1, 5),
            'genre_id' => $this->faker->numberBetween(1, 10),
            'production_info_id' => $this->faker->numberBetween(1, 5),
            'marketing_assets_id' => $this->faker->numberBetween(1, 5),
            'movie_id' => $this->faker->numberBetween(1, 5),
            'screener_id' => $this->faker->numberBetween(1, 5),
            'trailer_id' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->word() . " " . $this->faker->jobTitle() . " " . $this->faker->word(),
            'alternative_title' => $this->faker->jobTitle() . " " . $this->faker->word() . " " . $this->faker->word(),
            'content_type' => $this->faker->text(12),
            'runtime' => $this->faker->numberBetween(120, 240),
            'synopsis' => $this->faker->text(200),
            'keywords' => [
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word(),
            ],
            'languages' => [
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
