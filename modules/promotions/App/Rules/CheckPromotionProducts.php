<?php

namespace Modules\promotions\App\Rules;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\promotions\App\Models\PromotionProduct;

class CheckPromotionProducts implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $error = false;
        $products = $value;
        foreach($products as $product){
            $check = PromotionProduct::where([
                'variation_id' => $product['variation_id']
            ])->whereHas('promotion',function (Builder $builder){
                $builder->where('status',1)
                ->where('promotion_id','!=',request()->get('promotion_id'));
            })->first();
            if($check){
                $error = true;
            }
        }
        if($error){
            $fail('برخی از محصولات انتخاب شده در کمپین دیگری ثبت شده اند');
        }
    }
}
