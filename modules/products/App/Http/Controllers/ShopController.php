<?php

namespace Modules\products\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\products\App\Models\Product;
use Modules\products\App\Models\ProductCategory;

class ShopController extends Controller
{
    public function product($id, $slug)
    {
        $product = Product::query();
        $product->where([
            'id' => $id,
            'slug' => $slug,
        ]);
        if (config('shop-info.multi-seller') == 'true') {
            $product->with(['variations.seller']);
        } else {
            $product->with(['variations']);
        }
        $product = runEvent('shop:product-page', $product, true);
        $result = $product->firstOrFail();
        runEvent('product:after-show', $result);
        return $result;
    }

    public function productCategories($id)
    {
        return ProductCategory::where('product_id', $id)
            ->orderBy('category_id', 'ASC')
            ->pluck('category_id')
            ->toArray();
    }
}
