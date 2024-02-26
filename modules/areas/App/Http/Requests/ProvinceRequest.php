<?php

namespace Modules\areas\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string','max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام استان',
        ];
    }

}
