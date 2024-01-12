<?php

namespace Modules\warranties\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\warranties\App\Rules\PhoneNumber;

class WarrantyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required','string','max:255'],
            'link' => ['nullable','string','url','max:255'],
            'phone_number' => ['nullable','string',new PhoneNumber],
        ];

        if($this->hasFile('icon')){
            $rules['icon'] = ['image','max:512'];
        }

        return $rules;
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
