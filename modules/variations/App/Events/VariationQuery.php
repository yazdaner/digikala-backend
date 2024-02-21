<?php

namespace Modules\variations\App\Events;

use Modules\variations\App\Models\Variation;

class VariationQuery
{
    public function handle($function)
    {
        $variation = Variation::query();
        return $function($variation);
    }
}
