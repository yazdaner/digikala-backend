<?php

namespace Modules\blogs\database\factories;

use Modules\blogs\App\Models\BlogPost;
use Modules\blogs\App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        BlogCategory::factory()->create();
        $category = BlogCategory::select(['id'])->inRandomOrder()->first();
        return [
            'title' => fake()->text(10),
            'en_title' => fake()->text(10),
            'slug' => fake()->slug(),
            'category_id' => $category->id,
            'content' => fake()->text(10),
            'status' => true,
            'description' => fake()->paragraph(),
        ];
    }
}
