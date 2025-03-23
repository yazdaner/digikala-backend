<?php

namespace Modules\products\database\factories;

use Modules\brands\App\Models\Brand;
use Modules\sellers\App\Models\Seller;
use Modules\products\App\Models\Product;
use Modules\categories\App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $category = Category::select('id')->inRandomOrder()->first();
        $brand = Brand::select('id')->inRandomOrder()->first();
        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'title' => fake()->text(10),
            'en_title' => fake()->text(12),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'status' => 1,
            'user_id' => 1,
            'user_type' => Seller::class
        ];
    }
}
