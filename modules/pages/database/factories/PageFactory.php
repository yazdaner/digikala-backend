<?php

namespace Modules\pages\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\pages\App\Models\Page;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'en_title' => fake()->text(12),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph()
        ];
    }
}
