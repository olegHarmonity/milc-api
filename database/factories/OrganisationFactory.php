<?php

namespace Database\Factories;

use App\Models\Organisation;
use App\Util\CompanyStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganisationFactory extends Factory
{
    protected $model = Organisation::class;

    public function definition()
    {
        return [
            'organisation_name' => $this->faker->company(),
            'registration_number' => $this->faker->randomNumber(7),
            'phone_number' => $this->faker->phoneNumber(),
            'telephone_number' => $this->faker->phoneNumber(),
            'organisation_role' => 'buyer',
            'description' => Str::random(10),
            'website_link' => $this->faker->url(),
            'social_links' => [
                "facebook" => $this->faker->url(),
                "twitter" => $this->faker->url(),
                "linkedin" => $this->faker->url(),
                "telegram" => $this->faker->url(),
            ],
            'date_activated' => $this->faker->dateTime(),
            'status' => CompanyStatuses::$ACCEPTED,
            'user_id' => 1,
            'organisation_type_id' => 1,
            'logo_id' => 1,
            'country' => $this->faker->countryCode(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}