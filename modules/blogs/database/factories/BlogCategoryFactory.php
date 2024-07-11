<?php

namespace Modules\blogs\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\blogs\App\Models\BlogCategory;

class BlogCategoryFactory extends Factory
{
    protected $model = BlogCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'en_name' => fake()->text(10),
            'description' =>fake()->paragraph(),
            'icon' =>"['fas','house']",
            'slug' => fake()->slug(),
        ];
    }
}