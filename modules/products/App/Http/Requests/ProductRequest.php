<?php

namespace Modules\products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\warranties\App\Rules\PhoneNumber;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'link' => ['nullable','string','url','max:255'],
            'phone_number' => ['nullable','string',new PhoneNumber],
        ];
    }

    public function attributes() :array
    {
       return [
            'name' => 'نام گارانتی',
            'link' => 'لینک وب سایت',
            'phone_number' => 'شماره تماس',
       ];
    }
}
