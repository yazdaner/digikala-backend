<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\Product;
use Modules\products\App\Models\ProductsDetail;

class ProductInfo
{
    public function handle($product_id)
    {
        $hiddens = ['deleted_at', 'content', 'description', 'lowest_price'];
        $product = Product::where([
            'id' => $product_id
        ])->with(['category', 'brand'])
            ->first();
        if($product){
            $options = ProductsDetail::where('product_id',$product_id)->get();
            foreach ($hiddens as $hidden) {
                unset($product->$hidden);
            }
            foreach ($options as $option) {
                $key = $option['name'];
                $product->$key = $option['value'];
            }
            return $product;
        }
    }
}
