<?php

namespace Modules\promotions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\variations\App\Rules\UniqueVariation;

class PromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'type' => ['required','string'],
            'start_time' => ['required','string'],
            'end_time' => ['required','string'],
            'min_discount' => ['required','integer'],
            'min_products' => ['required','integer'],
            'category_id' => ['required','integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام کمپین',
            'type' => 'نوع',
            'start_time' => 'زمان شروع',
            'end_time' => 'زمان پایان',
            'min_discount' => 'حداقل تخفیف',
            'min_products' => 'حداقل تعداد محصول',
            'category_id' => 'دسته بندی',
        ];
    }
}
