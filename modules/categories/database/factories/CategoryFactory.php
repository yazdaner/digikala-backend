<?php

namespace Modules\categories\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\categories\App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'en_name' => fake()->name(),
            'icon' => "['fas', 'music']",
        ];
    }
}
