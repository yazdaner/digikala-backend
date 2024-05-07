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
            'address_id' => ['required','numeric'],
            'payment_method' => ['required','string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'address_id' => 'آدرس',
            'payment_method' => 'روش پرداخت',
       ];
    }
}
