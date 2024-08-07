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
            'encrypted' => ['required', 'string'],
            'code' => ['required', 'integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'encrypted' => 'توکن',
            'code' => 'کد تایید',
        ];
    }
}
