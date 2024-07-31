<?php

namespace Modules\promotions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required','integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'دسته بندی',
        ];
    }
}
