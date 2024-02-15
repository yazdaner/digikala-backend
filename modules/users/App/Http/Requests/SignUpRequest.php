<?php

namespace Modules\users\App\Http\Requests;

use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                Rule::unique('users')->where('status', 1)
            ],
            'password' => ['required','string','min:8','max:200'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'نام کاربری',
            'password' => 'کلمه عبور',
        ];
    }
}
