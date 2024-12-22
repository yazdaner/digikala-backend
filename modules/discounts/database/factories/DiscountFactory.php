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
            'code' => fake()->text(5),
            'expiration_date' => '1403/10/02',
            'percent' =>  rand(5, 50),
            'amount' => rand(100000, 1000000),
            'max_amount' => rand(100000, 1000000),
            'min_purchase' => rand(1, 10),
            'category_id' => 0,
        ];
    }
}
