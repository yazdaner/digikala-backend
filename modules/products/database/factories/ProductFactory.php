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
            'name' => fake()->text(10),
            'link' => fake()->url(),
            'phone_number' => fake()->phoneNumber()
        ];
    }
}
