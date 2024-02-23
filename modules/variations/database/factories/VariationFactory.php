<?php

namespace Modules\variations\database\factories;

use Modules\colors\App\Models\Color;
use Modules\warranties\App\Models\Warranty;
use Modules\variations\App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\products\App\Models\Product;

class VariationFactory extends Factory
{
    protected $model = Variation::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->create(['slug' => 'test'])->id,
            'price1' => rand(9999, 99999),
            'price2' => rand(9999, 99999),
            'product_count' => rand(1, 100),
            'max_product_cart' => rand(1, 5),
            'preparation_time' => rand(1, 5),
            'param1_type' => Color::class,
            'param1_id' => rand(1, 99),
            'param2_type' => Warranty::class,
            'param2_id' => rand(1, 99),
        ];
    }
}

