<?php

namespace Modules\discounts\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\discounts\App\Models\Discount;

class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
        ];
    }
}
