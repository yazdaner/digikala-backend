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
            'promotion_id' => ['required', 'exists:promotions,id'],
            'products' => ['required', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'promotion_id' => 'پروموشن',
            'products' => 'محصولات',
        ];
    }
}
