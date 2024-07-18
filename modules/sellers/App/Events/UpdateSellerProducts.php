<?php

namespace Modules\sellers\App\Events;

use Illuminate\Support\Facades\Auth;
use Modules\sellers\App\Models\SellerProduct;

class UpdateSellerProducts
{
    public function handle($product)
    {
        if(Auth::guard('seller')->check()){
            $seller = Auth::guard('seller')->user();
            $product->seller_id = $seller->id;
            $product->update();
            SellerProduct::create([
                'product_id' => $product->id,
                'seller_id' => $seller->id,
            ]);
        }
    }
}
