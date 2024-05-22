<?php

namespace Modules\faq\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required'
        ];
        if ($this->isMethod('POST') || !empty($this->get('icon'))) {
            $rules['icon'] = ['required', 'image', 'max:1024'];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام دسته',
            'icon' => 'آیکون',
        ];
    }
}
