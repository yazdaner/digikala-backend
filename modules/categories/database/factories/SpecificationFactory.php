<?php

namespace Modules\categories\database\factories;

use Modules\categories\App\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecificationFactory extends Factory
{
    protected $model = Specification::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'important' => fake()->boolean(),
        ];
    }
}
