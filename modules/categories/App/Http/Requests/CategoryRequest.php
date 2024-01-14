<?php

namespace Modules\categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required','string','max:255'],
            'link' => ['nullable','string','url','max:255'],
        ];

        return $rules;
    }

    public function attributes() :array
    {
       return [
            'name' => 'نام گارانتی',
            'link' => 'لینک وب سایت',
            'phone_number' => 'شماره تماس',
       ];
    }
}
