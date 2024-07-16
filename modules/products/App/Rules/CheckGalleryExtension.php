<?php

namespace Modules\products\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckGalleryExtension implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = true;
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $extension = $value->getClientOriginalExtension();
        if (in_array($extension, $allowedExtensions) == false) {
            $result = false;
        }
        if ($result == false) {
            $fail('png,jpg,jpeg پسوند های مجاز تصویر برای آپلود');
        }
    }
}
