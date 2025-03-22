<?php

namespace Modules\brands\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'en_name' => ['required', 'string'],
            'icon' => ['nullable', 'image', 'max:512']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام',
            'en_name' => 'نام انگلیسی',
            'icon' => 'آیکون',
        ];
    }
}
