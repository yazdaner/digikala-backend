<?php

namespace Modules\sliders\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'en_title' => ['required','string','max:255'],
            'slug' => ['required','string','max:255'],
            'content' => ['required','string'],
            'description' => ['string'],
            'tags' => ['string'],
        ];
    }

    public function attributes() :array
    {
       return [
            'title' => 'عنوان',
            'en_title' => 'عنوان انگلیسی',
            'content' => 'محتوای صفحه',
       ];
    }
}
