<?php

namespace Modules\cart\App\Actions;

use App\Http\Controllers\Controller;

class CartProducts extends Controller
{
    public function __invoke($data,$cart,$request)
    {
        $products = [];
        foreach ($data as $variationId => $count) {
            $product = null;
            $variation =runEvent('variation:query',function($query) use ($variationId){
                return $query->with(['param1','param2'])->find($variationId);
            },true);
            if(is_object($variation)){
                $product = runEvent('product:info',$variation->product_id,true);
                if(is_object($product)){
                    
                }
            }
        }
        return $products;
    }
}
