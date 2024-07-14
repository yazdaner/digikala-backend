<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\sellers\App\Rules\CheckNationalCode;
use Modules\sellers\App\Rules\CheckBankCartNumber;

class InformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nationalCode' => [
                'required',
                new CheckNationalCode(),
                Rule::unique('sellers__information', 'value')->where('name', 'nationalCode')
            ],
            'brandName' => ['required', 'string']
        ];
        if ($this->get('cartNumber') !== '') {
            $rules['cartNumber'] = [
                new CheckBankCartNumber(),
                Rule::unique('sellers__bank_cart_numbers', 'number')
            ];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'nationalCode' => 'کد ملی',
            'brandName' => 'نام فروشگاه',
            'cartNumber' => 'شماره کارت',
        ];
    }
}
