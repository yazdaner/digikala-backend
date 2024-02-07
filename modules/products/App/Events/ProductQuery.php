<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\Product;

class ProductQuery
{
    public function handle($function)
    {
        $product = Product::query();
        return $function($product);
    }
}
