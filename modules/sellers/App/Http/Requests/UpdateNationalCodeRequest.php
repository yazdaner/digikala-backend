<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Modules\sellers\App\Rules\CheckNationalCode;

class UpdateNationalCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $seller = Auth::user();
        return [
            'nationalCode' => [
                'required',
                new CheckNationalCode,
                Rule::unique('sellers__information','value')
                    ->where('name', 'nationalCode')
                    ->whereNot('seller_id', $seller->id)
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'nationalCode' => 'کد ملی',
        ];
    }
}
