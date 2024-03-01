<?php

namespace Modules\addresses\database\factories;

use Modules\addresses\App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'address' => fake()->streetAddress(),
            'plaque' => fake()->numberBetween(1,100),
            'postal_code' => fake()->numberBetween(99999999,9999999999),
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'recipient_name' => fake()->firstName(),
            'recipient_last_name' => fake()->lastName(),
            'recipient_mobile_number' => fake()->phoneNumber(),
        ];
    }
}
