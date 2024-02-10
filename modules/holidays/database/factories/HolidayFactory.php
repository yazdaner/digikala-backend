<?php

namespace Modules\holidays\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\holidays\App\Models\Holiday;

class HolidayFactory extends Factory
{
    protected $model = Holiday::class;

    public function definition(): array
    {
        return [
            'shop_id' => fake()->rand(1,99),
            'date' => fake()->date(),
            'timestamp' => fake()->time(),
            'explain' => fake()->text(10)
        ];
    }
}


