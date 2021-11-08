<?php

namespace Database\Factories;

use App\Models\MovieFormat;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFormatFactory extends Factory
{
    protected $model = MovieFormat::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
