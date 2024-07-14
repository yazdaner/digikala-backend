<?php

namespace Modules\sellers\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckNationalCode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $res = false;
        if(is_numeric($value)){
            $sum =0;
            for ($i=0; $i < 9; $i++) { 
                $n = intval(substr($value,$i,1));
                $sum += (10-$i)*$n;
            }
            $ret = $sum % 11;
            $parity = substr($value,9,1);
            if(($ret < 2 && $ret == $parity) || ($ret > 2 && $ret == (11-$parity))){
                $res = true;
            }
        }
        if(!$res){
            $fail('کد ملی وارد شده نامعتبر می باشد');
        }
    }
}
