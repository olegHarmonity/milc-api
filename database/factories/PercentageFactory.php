<?php

namespace Database\Factories;

use App\Models\Percentage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PercentageFactory extends Factory
{
    protected $model = Percentage::class;

    public function definition()
    {
        return [
            'value' => rand(0,25)
        ];
    }
    
    public static function createPercentage(float $value)
    {
        $percentage = new Percentage();
        $percentage->value = $value;
        
        return $percentage;
    }
}
