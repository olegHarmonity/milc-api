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
            'value' => rand(100000, 1000000) + mt_rand( 0, 100 ) / 100,
            'currency' => array_rand([
                'EUR' => 0,
                'GBP' => 1,
                'USD' => 2
            ], 1)
        ];
    }

    public static function createMoney(float $value, string $currency)
    {
        $money = new Money();
        $money->value = $value;
        $money->currency = $currency;

        return $money;
    }
}
