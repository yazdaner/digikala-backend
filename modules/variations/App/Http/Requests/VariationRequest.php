<?php

namespace Modules\variations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\variations\App\Rules\UniqueVariation;

class VariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'price1' => ['required', 'numeric'],
            'price2' => ['required', 'numeric'],
            'product_count' => ['required', 'numeric', new UniqueVariation],
        ];
        if (!empty($this->request->get('preparation_time'))) {
            $rules['preparation_time'] = ['numeric'];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'price1' => 'قیمت محصول',
            'price2' => 'قیمت محصول برای فروش',
            'product_count' => 'تعداد موجودی محصول',
            'max_product_cart' => 'حد اکثر تعداد سفارش در سبد خرید',
            'preparation_time' => 'زمان آماده سازی محصول',
        ];
    }

    protected function getValidatorInstance()
    {
        $array = ['price1', 'price2', 'product_count', 'max_product_cart', 'preparation_time'];
        foreach ($array as $value) {
            if ($this->request->has($value)) {
                $this->merge([
                    $value => str_replace(',', '', $this->request->get($value))
                ]);
            }
        }
        return parent::getValidatorInstance();
    }
}
