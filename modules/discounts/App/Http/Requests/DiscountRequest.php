<?php

namespace Modules\discounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return  [
            'code' => ['required','string'],
            'expiration_time' => ['required','string'],
            'percent' => ['nullable','integer'],
            'amount' => ['required_without:percent','integer'],
            'max_amount' => ['nullable','integer'],
            'min_purchase' => ['nullable','integer'],
        ];
    }

    public function attributes()
    {
        return [
            "code" => "کد تخفیف",
            "expiration_time" => "تاریخ انقضا",
            "percent" => "درصد تخفیف",
            "amount" => "مقدار تخفیف (تومان)",
            "max_amount" => "حداکثر تخفیف (تومان)",
            "min_purchase" => "حداقل تخفیف",
        ];
    }
}
