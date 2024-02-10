<?php

namespace Modules\holidays\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckData implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

    }
}
