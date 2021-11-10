<?php

namespace Database\Factories;

use App\Models\MovieContentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieContentTypeFactory extends Factory
{
    protected $model = MovieContentType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
