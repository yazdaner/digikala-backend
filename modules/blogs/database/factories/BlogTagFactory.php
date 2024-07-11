<?php

namespace Modules\blogs\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\blogs\App\Models\BlogTag;

class BlogTagFactory extends Factory
{
    protected $model = BlogTag::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'description' =>fake()->paragraph(),
        ];
    }
}