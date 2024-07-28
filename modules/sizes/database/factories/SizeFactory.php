<?php

namespace Modules\sizes\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\sizes\App\Models\Size;

class SizeFactory extends Factory
{
    protected $model = Size::class;

    public function definition(): array
    {
        return [
            'name' => fake()->numberBetween(1,5),
        ];
    }
}
