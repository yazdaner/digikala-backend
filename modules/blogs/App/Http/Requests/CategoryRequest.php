<?php

namespace Modules\blogs\App\Http\Requests;

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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
        if(!empty($this->icon)){
            $rules['icon'] = 'string'; 
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام دسته',
            'description' => 'توضیحات',
            'icon' => 'ایکون',
        ];
    }
}
