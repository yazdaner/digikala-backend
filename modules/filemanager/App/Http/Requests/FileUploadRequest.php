<?php

namespace Modules\filemanager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'mimes:mp4,png,jpg,jpeg,webp,gif,pdf,txt'],
            'fileDirectory' => ['required', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'فایل',
            'fileDirectory' => 'مسیر فایل'
        ];
    }
}
