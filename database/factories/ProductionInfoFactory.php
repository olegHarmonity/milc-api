<?php

namespace Database\Factories;

use App\Models\ProductionInfo;
use App\Util\ProductionStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionInfoFactory extends Factory
{
    protected $model = ProductionInfo::class;

    public function definition()
    {
        $productionStatuses = [ProductionStatuses::$RELEASED, ProductionStatuses::$UNRELEASED];
        $statusKey = array_rand($productionStatuses);

        return [
            'product_id' => $this->faker->numberBetween(1,5),
            'release_year' => $this->faker->date(),
            'production_year' => $this->faker->date(),
            'production_status' => $productionStatuses[$statusKey],
            'country_of_origin' => $this->faker->countryCode(),
            'awards' => [
                "Award 1" => "Award 1 description"
            ],
            'festivals' => [
                "Festival 1" => "Festival 1 description"
            ],
            'box_office' => [
                "Global GBO" => $this->faker->numberBetween(1000,10000000).",".$this->faker->numberBetween(0,99)." USD",
                "Domestic (US) GBO" => $this->faker->numberBetween(1000,10000000).",".$this->faker->numberBetween(0,99)." USD",
                "International GBO" => $this->faker->numberBetween(1000,10000000).",".$this->faker->numberBetween(0,99)." USD",
            ],
        ];
    }
}
