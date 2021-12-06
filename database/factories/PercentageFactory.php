<?php

namespace Database\Factories;

use App\Models\Percentage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PercentageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Percentage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
    
    public static function createPercentage(float $value)
    {
        $money = new Percentage();
        $money->value = $value;
        
        return $money;
    }
}
