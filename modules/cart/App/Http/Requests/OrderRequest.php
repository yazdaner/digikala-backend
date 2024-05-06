<?php

namespace Modules\cart\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'addressId' => ['required','numeric'],
            'payment_method' => ['required','string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'addressId' => 'آدرس',
            'payment_method' => 'روش پرداخت',
       ];
    }
}
