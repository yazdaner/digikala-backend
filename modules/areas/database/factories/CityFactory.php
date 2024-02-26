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
        return [
            'province_id' => Province::first()->id,
            'name' => fake()->text(10),
        ];
    }
}
