<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\Product;

class ProductQuery
{
    public function handle($function)
    {
        $query = Product::query();
        return $function($query);
    }
}
