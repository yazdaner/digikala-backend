<?php

namespace Modules\holidays\App\Rules;

use Closure;
use Modules\core\Lib\Jdf;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckData implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $jdf = new Jdf;
        // $now = timestamp($jdf->jdate('Y'), $jdf->jdate('n'), $jdf->jdate('j'));
        $now = Carbon::now()->timestamp;
        $arr = explode('/',$value);
        if(sizeof($arr) != 3){
            $fail('فرمت تاریخ اشتباه می باشد');
        }
        $selectedTimestamp = timestamp($arr[0],$arr[1],$arr[2]);
        if(($selectedTimestamp - $now) <= (48*60*60)){
            $fail('تاریخ انتخابی باید حداقل دو روز یعد از تاریخ فعلی باشد');
        }
    }
}
