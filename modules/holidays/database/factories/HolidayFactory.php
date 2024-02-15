<?php

namespace Modules\holidays\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\core\Lib\Jdf;
use Modules\holidays\App\Models\Holiday;

class HolidayFactory extends Factory
{
    protected $model = Holiday::class;

    public function definition(): array
    {
        $timestamp = fake()->dateTimeBetween(now()->addDays(3),now()->addDays(10))->getTimestamp();
        $jdf = new Jdf;
        return [
            'date' => $jdf->jdate('Y/n/d',$timestamp),
            'explain' => fake()->sentence()
        ];
    }
}


