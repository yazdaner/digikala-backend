<?php

namespace Modules\blogs\App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('blog__tags')->ignore($this->tag)],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام تگ',
        ];
    }
}
