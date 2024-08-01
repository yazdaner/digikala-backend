<?php

namespace Modules\promotions\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPromotionProductsInventory implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $error = false;
        $products = $value;
        foreach ($products as $product) {
            $result = runEvent('variation:query', function ($query) use ($product) {
                return $query->where('id', $product['variation_id'])
                    ->where('product_count', '>=', $product['count'])
                    ->first();
            }, true);
            if (!$result) {
                $error = true;
            }
        }
        if ($error) {
            $fail('موجودی برخی محصولات بیشتر از مقدار مجاز برای فروش است');
        }
    }
}
