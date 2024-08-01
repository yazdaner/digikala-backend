<?php

namespace Modules\promotions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\promotions\App\Rules\CheckPromotionProducts;
use Modules\promotions\App\Rules\CheckPromotionProductsInventory;

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
            'products' => ['required', 'array' , new CheckPromotionProducts(),new CheckPromotionProductsInventory()],
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
