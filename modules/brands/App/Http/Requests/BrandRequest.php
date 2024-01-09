<?php

namespace Modules\brands\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required','string'],
            'en_name' => ['required','string'],
        ];

        if($this->hasFile('icon')){
            $rules['icon'] = ['image','max:512'];
        }

        return $rules;
    }
}
