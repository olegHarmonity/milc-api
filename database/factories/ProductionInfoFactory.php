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
            'release_year' => rand(2018,2021),
            'production_year' => rand(2018,2021),
            'production_status' => $productionStatuses[$statusKey],
            'country_of_origin' => $this->faker->countryCode(),
            'awards' => ["Award 1", "Award 2"],
            'festivals' => ["Festival 1", "Festival 2"],
            'box_office' => [
                "globalGbo" => $this->faker->numberBetween(1000, 10000000) . "," . $this->faker->numberBetween(0, 99) . " USD",
                "domesticGbo" => $this->faker->numberBetween(1000, 10000000) . "," . $this->faker->numberBetween(0, 99) . " USD",
                "internationalGbo" => $this->faker->numberBetween(1000, 10000000) . "," . $this->faker->numberBetween(0, 99) . " USD",
            ],
        ];
    }
}
