<?php

namespace Modules\products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => ['required','string','max:255'],
            'en_title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'content' => ['nullable','string'],
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
