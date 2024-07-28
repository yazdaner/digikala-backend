<?php

namespace Modules\sizes\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'name' => 'نام',
       ];
    }
}
