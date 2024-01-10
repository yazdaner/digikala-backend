<?php

namespace Modules\colors\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\colors\App\Models\Color;

class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition(): array
    {
        return [
            'name' => fake()->colorName(),
            'code' => fake()->hexColor()
        ];
    }
}
