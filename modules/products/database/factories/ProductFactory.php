<?php

namespace Modules\products\database\factories;

use Modules\products\App\Models\Product;
use Modules\categories\App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $category = Category::select('id')->inRandomOrder()->first();
        return [
            'category_id' => $category->id,
            'title' => fake()->text(10),
            'en_title' => fake()->text(12),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'status' => 1
        ];
    }
}
