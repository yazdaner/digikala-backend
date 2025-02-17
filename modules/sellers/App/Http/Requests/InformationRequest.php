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
        return [
            'nationalCode' => [
                'required',
                new CheckNationalCode(),
                Rule::unique('sellers__information', 'value')->where('name', 'nationalCode')
            ],
            'brandName' => ['required', 'string'],
            'cartNumber' => ['nullable', new CheckBankCartNumber(),]
        ];
    }

    public function attributes(): array
    {
        return [
            'nationalCode' => 'کد ملی',
            'brandName' => 'نام فروشگاه',
            'cartNumber' => 'شماره کارت',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'cartNumber' => str_replace('-', '', $this->cartNumber)
        ]);
    }
}
