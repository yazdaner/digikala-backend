<?php

namespace Modules\variations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'product_count' => ['required', 'numeric'],
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
        if ($this->request->has('price1')) {
            $this->merge([
                'price1' => str_replace(',', '', $this->request->get('price1'))
            ]);
        }
        if ($this->request->has('price2')) {
            $this->merge([
                'price2' => str_replace(',', '', $this->request->get('price2'))
            ]);
        }
        if ($this->request->has('product_count')) {
            $this->merge([
                'product_count' => str_replace(',', '', $this->request->get('product_count'))
            ]);
        }
        if ($this->request->has('max_product_cart')) {
            $this->merge([
                'max_product_cart' => str_replace(',', '', $this->request->get('max_product_cart'))
            ]);
        }
        if ($this->request->has('preparation_time')) {
            $this->merge([
                'preparation_time' => str_replace(',', '', $this->request->get('preparation_time'))
            ]);
        }
        return parent::getValidatorInstance();
    }
}
