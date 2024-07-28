<?php

namespace Modules\variations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['mimes:xls,xlsx']
        ];
    }

    public function attributes(): array
    {
        return [
            'file' => 'فایل اکسل',
        ];
    }
}
