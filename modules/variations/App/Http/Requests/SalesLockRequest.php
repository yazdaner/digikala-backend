<?php

namespace Modules\variations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\variations\App\Rules\UniqueVariation;

class SalesLockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'description' => ['required', 'string'],
        ];
        if (!empty($this->category_id)) {
            $rules['category_id'] = ['integer'];
        }
        if (!empty($this->brand_id)) {
            $rules['brand_id'] = ['integer'];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'description' => 'قفل فروش',
            'category_id' => 'شناسه دسته',
            'brand_id' => 'شناسه برند',
        ];
    }
}
