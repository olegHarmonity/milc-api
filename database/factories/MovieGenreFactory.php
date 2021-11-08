<?php

namespace Database\Factories;

use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieGenreFactory extends Factory
{
    protected $model = MovieGenre::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
