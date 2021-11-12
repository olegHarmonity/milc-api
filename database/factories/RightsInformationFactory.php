<?php

namespace Database\Factories;

use App\Models\RightsInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class RightsInformationFactory extends Factory
{
    protected $model = RightsInformation::class;

    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 5),
            'available_from_date' => $this->faker->date(),
            'expiry_date' => $this->faker->date(),
            'holdbacks' => $this->faker->text(20),
            'territories' => [
                "worldwide" => [$this->faker->country(), $this->faker->country(), $this->faker->country()],
                "region" => [$this->faker->country(), $this->faker->country(), $this->faker->country()],
                "territory" => [$this->faker->country(), $this->faker->country(), $this->faker->country()],
            ],
        ];
    }
}
