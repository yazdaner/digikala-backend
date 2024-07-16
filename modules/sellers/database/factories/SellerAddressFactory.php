<?php

namespace Modules\sellers\database\factories;

use Modules\areas\App\Models\Province;
use Modules\sellers\App\Models\SellerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\areas\App\Models\City;

class SellerAddressFactory extends Factory
{
    protected $model = SellerAddress::class;

    public function definition(): array
    {
        $city = City::factory()->create();
        return [
            'address' => fake()->streetAddress(),
            'plaque' => fake()->numberBetween(1,100),
            'postal_code' => fake()->numberBetween(99999999,9999999999),
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'city_id' => $city->id,
            'province_id' => $city->province->id,
        ];
    }
}

