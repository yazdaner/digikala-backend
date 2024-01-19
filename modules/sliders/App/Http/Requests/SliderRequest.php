<?php

namespace Modules\sliders\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\sliders\App\Rules\PhoneNumber;

class SliderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'url' => ['required','string','max:255'],
            'image' => ['nullable','image'],
            'mobile_image' => ['nullable','image'],
        ];
    }

    public function attributes() :array
    {
       return [
            'title' => 'عنوان',
            'url' => 'آدرس',
            'image' => 'تصویر',
            'mobile_image' => 'تصویر موبایل',
       ];
    }
}
