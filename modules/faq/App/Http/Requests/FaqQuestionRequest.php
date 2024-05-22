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
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string', 'exists:faq__categories,id'],
            'answer' => ['required', 'image'],
            'short_answer' => ['required', 'image'],
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
