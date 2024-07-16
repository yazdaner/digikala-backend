<?php

namespace Modules\products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\products\App\Rules\CheckGalleryExtension;

class GalleryUploadRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'files.*' => [new CheckGalleryExtension]
        ];
    }
}
