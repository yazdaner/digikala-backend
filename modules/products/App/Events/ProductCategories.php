<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\ProductCategory;

class ProductCategories
{
    public function handle($product_id)
    {
        return ProductCategory::where('product_id', $product_id)
            ->pluck('category_id')
            ->toArray();
    }
}
