<?php

namespace Modules\discounts\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateValidate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/', $value)) {
            $fail('فرمت تاریخ ارسال شده نامعتبر می باشد');
        }
    }
}
