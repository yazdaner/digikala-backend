<?php

namespace Modules\areas\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\areas\App\Models\Province;

class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    public function definition(): array
    {
        return [
            'name' => fake()->state,
        ];
    }
}
