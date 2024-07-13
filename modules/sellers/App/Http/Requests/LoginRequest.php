<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required','string'],
            'password' => ['required','string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'نام کاربری',
            'password' => 'پسورد',
        ];
    }
}
