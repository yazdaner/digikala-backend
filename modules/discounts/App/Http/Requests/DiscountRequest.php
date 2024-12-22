<?php

namespace Modules\discounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\discounts\App\Rules\DateValidate;

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
            'expiration_date' => ['required','string',new DateValidate()],
            'percent' => ['nullable','integer'],
            'amount' => ['required_without:percent','nullable','integer'],
            'max_amount' => ['nullable','integer'],
            'min_purchase' => ['nullable','integer'],
            'category_id' => ['required','integer'],
        ];
    }

    public function attributes()
    {
        return [
            "code" => "کد تخفیف",
            "expiration_date" => "تاریخ انقضا",
            "percent" => "درصد تخفیف",
            "amount" => "مقدار تخفیف (تومان)",
            "max_amount" => "حداکثر تخفیف (تومان)",
            "min_purchase" => "حداقل تخفیف",
            "category_id" => "دسته بندی",
        ];
    }
}
