<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'street_name' => $this->faker->streetName,
            'house_number' => $this->faker->numberBetween(1, 100),
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
        ];
    }
}
