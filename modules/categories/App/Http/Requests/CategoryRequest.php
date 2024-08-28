<?php

namespace Modules\categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\categories\App\Rules\CheckCategoryEnglishName;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required','string','max:255'],
            'parent_id' => ['nullable','integer'],
        ];
        if($this->hasFile('image')){
            $rules['image'] = ['image','max:512'];
        }
        if(empty($this->request->get('en_name'))){
            $rules['url'] = ['required'];
        }
        else{
            $rules['en_name'] = ['required','string','max:255',new CheckCategoryEnglishName($this->category)];
        }
        return $rules;
    }

    public function attributes() :array
    {
       return [
            'name' => 'نام',
            'en_name' => 'نام انگلیسی',
            'image' => 'تصویر',
            'url' => 'آدرس',
       ];
    }
}
