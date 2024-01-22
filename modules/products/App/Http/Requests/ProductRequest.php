<?php

namespace Modules\products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required','string','max:255'],
            'en_title' => ['required','string','max:255'],
        ];
        return runEvent('create-product-rules',$rules,true);
    }

    public function attributes() :array
    {
       return [
            'title' => 'عنوان',
            'en_title' => 'عنوان انگلیسی',
       ];
    }
}
