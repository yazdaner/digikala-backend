<?php

namespace Modules\brands\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\brands\App\Models\Brand;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => fake()->title(),
            'en_name' => fake()->title()
        ];
    }
}
