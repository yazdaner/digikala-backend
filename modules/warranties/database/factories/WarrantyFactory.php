<?php

namespace Modules\warranties\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\warranties\App\Models\Warranty;

class WarrantyFactory extends Factory
{
    protected $model = Warranty::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'link' => fake()->url(),
            'phone_number' => fake()->phoneNumber()
        ];
    }
}
