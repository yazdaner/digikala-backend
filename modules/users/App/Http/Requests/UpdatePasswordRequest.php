<?php

namespace Modules\users\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required'],
            'password' => ['required','confirmed','string','min:8','max:200'],
        ];
    }

    public function attributes(): array
    {
        return [];
    }
}
