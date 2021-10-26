<?php

namespace Database\Factories;

use App\Models\Organisation;
use App\Util\CompanyStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganisationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organisation_name' => $this->faker->company(),
            'registration_number' => $this->faker->randomNumber(7),
            'phone_number' => $this->faker->phoneNumber(),
            'telephone_number' => $this->faker->phoneNumber(),
            'organisation_role' => 'Buyer',
            'description' => Str::random(10),
            'website_link' => $this->faker->url(),
            'social_links' => json_encode([$this->faker->url(),$this->faker->url()]),
            'date_activated' => $this->faker->dateTime(),
            'status' => CompanyStatuses::$ACCEPTED,
            'user_id' => 1,
            'organisation_type_id' => 1,
            'logo_id' => 1
        ];
    }
}
