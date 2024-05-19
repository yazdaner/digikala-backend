<?php

namespace Modules\questions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:500'],
            'product_id' => ['required', 'int'],
        ];
    }

    public function attributes(): array
    {
        return [
            'content' => 'پرسش',
            'product_id' => 'شناسه محصول',
        ];
    }
}
