<?php

namespace Modules\faq\database\factories;

use Modules\faq\App\Models\FaqQuestions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\faq\App\Models\FaqCategories;

class FaqQuestionsFactory extends Factory
{
    protected $model = FaqQuestions::class;

    public function definition(): array
    {
        return [
            'category_id' => FaqCategories::select(['id'])->inRandomOrder()->first()->id,
            'title' => fake()->text(10),
            'answer' => fake()->text(20),
            'short_answer' => fake()->text(5),
        ];
    }
}
