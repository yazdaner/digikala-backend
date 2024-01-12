<?php

namespace Modules\warranties\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = str_replace('+','',$value);
        $value = str_replace('-','',$value);
        $value = str_replace('(','',$value);
        $value = str_replace(')','',$value);
        $value = str_replace('+','',$value);
        $value = str_replace('.','',$value);
        $value = preg_replace('/\s+/','',$value);
        $number = intval($value);
        if(! strlen($number) >= 10){
            $fail('شماره وارد شده معتبر نمیباشد');
        }
    }
}
