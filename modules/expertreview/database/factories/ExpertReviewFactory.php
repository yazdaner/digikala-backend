<?php

namespace Modules\expertreview\database\factories;

use Modules\expertreview\App\Models\ExpertReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpertReviewFactory extends Factory
{
    protected $model = ExpertReview::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'description' => fake()->paragraph(),
        ];
    }
}
