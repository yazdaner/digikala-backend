<?php

namespace Modules\faq\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:faq__categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'short_answer' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'category_id' => 'دسته پرسش',
            'answer' => 'پاسخ',
            'short_answer' => 'پاسخ کوتاه',
        ];
    }
}
