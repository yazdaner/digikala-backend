<?php

namespace Modules\products\App\Actions;

use Illuminate\Http\Request;
use Modules\products\App\Models\ProductKeyword;

class AddKeywords
{
    public function __invoke($product, Request $request)
    {
        ProductKeyword::where('product_id', $product->id)->delete();
        $keywords = $request->get('keywords');
        $array = explode(',', $keywords);
        foreach ($array as $value) {
            if (!empty($value)) {
                ProductKeyword::create([
                    'product_id' => $product->id,
                    'tag' => $value
                ]);
            }
        }
    }
}
