<?php

namespace Modules\blogs\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'en_title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
        if (!empty($this->image)) {
            $rules['image'] = ['image','max:1024'];
        }
        if (!empty($this->image)) {
            $rules['videoLink'] = ['string','url'];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'en_title' => 'عنوان انگلیسی',
            'content' => 'محتوا',
            'image' => 'تصویر شاخص',
            'videoLink' => 'لینک ویدیو',
        ];
    }
}
