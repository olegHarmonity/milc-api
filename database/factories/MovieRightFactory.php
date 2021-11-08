<?php

namespace Database\Factories;

use App\Models\MovieRight;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieRightFactory extends Factory
{
    protected $model = MovieRight::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
