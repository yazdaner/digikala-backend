<?php

namespace Modules\sellers\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckBankCartNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = replaceFaNumber($value);
        if( !is_numeric($value) || strlen($value) != 16){
            $fail('شماره کارت وارد شده نامعتبر می باشد');
        }
    }
}
