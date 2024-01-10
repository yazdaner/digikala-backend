<?php

namespace Modules\colors\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'code' => ['required','string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'name' => 'نام',
            'code' => 'کد رنگ',
       ];
    }
}
