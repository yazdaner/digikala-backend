<?php

namespace Modules\promotions\database\factories;

use Modules\promotions\App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'type' => 'amazing',
            'start_time' => strtotime('today'),
            'end_time' => strtotime('+'.rand(4,15).'day'),
            'min_discount' => rand(4,15),
            'min_products' => rand(4,15),
            'category_id' => 0,
            'status' => 1,
        ];
    }
}
