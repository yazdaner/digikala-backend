<?php

namespace Modules\expertreview\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpertReviewRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'title' => 'عنوان',
            'description' => 'توضیحات',
       ];
    }
}
