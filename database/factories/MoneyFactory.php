<?php

namespace Database\Factories;

use App\Models\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoneyFactory extends Factory
{
    
    protected $model = Money::class;

    public function definition()
    {
        return [
            'value' => rand(100000, 1000000),
            'currency' => array_rand(['EUR','GBP','USD'])
        ];
    }
}
