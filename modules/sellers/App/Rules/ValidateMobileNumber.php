<?php

namespace Modules\sellers\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateMobileNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = false;
        settype($value, 'integer');
        if (strlen($value) == 10 && is_numeric($value) && substr($value, 0, 1) == 9) {
            $result = true;
        }
        if (!$result) {
            $fail('شماره موبایل وارد شده نامعتبر می باشد');
        }
    }
}
