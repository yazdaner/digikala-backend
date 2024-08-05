<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required','email','unique:sellers,email'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'ایمیل',
        ];
    }
}
