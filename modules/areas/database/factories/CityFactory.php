<?php

namespace Modules\areas\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\areas\App\Models\City;
use Modules\areas\App\Models\Province;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        Province::factory()->create();
        return [
            'province_id' => Province::inRandomOrder()->first()->id,
            'name' => fake()->state,
        ];
    }
}
