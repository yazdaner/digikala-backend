<?php

namespace Modules\products\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\products\App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'en_title' => fake()->text(12),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'status' => 1
        ];
    }
}
