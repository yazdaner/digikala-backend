<?php

namespace Modules\sliders\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\sliders\App\Models\Slider;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'link' => fake()->url(),
            'phone_number' => fake()->phoneNumber()
        ];
    }
}
