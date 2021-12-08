<?php
namespace Database\Factories;

use App\Models\GeneralAdminSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralAdminSettingsFactory extends Factory
{
    protected $model = GeneralAdminSettings::class;

    public function definition()
    {
        return [
            'iban' => 'DE89370400440532013000',
            'swift_bic' => 'DEUTDEMM760',
            'bank_name' => $this->faker->city().' bank inc.',
        ];
    }
}
