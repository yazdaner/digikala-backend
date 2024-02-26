<?php

namespace Modules\areas\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string','max:255'],
            'province_id' => ['required', 'integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام شهر',
            'province_id' => 'استان'
        ];
    }

}
