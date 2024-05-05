<?php

namespace Modules\cart\App\Actions;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartProducts extends Controller
{
    public function __invoke($data, $cart, $request)
    {
        $products = [];
        foreach ($data as $variationId => $count) {
            $product = null;
            $variation = runEvent('variation:query', function ($query) use ($variationId) {
                return $query->with(['param1', 'param2'])->find($variationId);
            }, true);
            if (is_object($variation) && isset($variation->product_id)) {
                $product = runEvent('product:info', $variation->product_id, true);
                if (is_object($product)) {
                    $totalProducts = runEvent('variation:query', function ($query) use ($product) {
                        return $query->where('product_id', $product->id)->sum('product_count');
                    });
                    $variation->total = $totalProducts;
                    $product->variation = $variation;
                    $product->count = $count;
                    if ($request->get('check-change') == 'true') {
                        $checkChange = $this->updateChangePrice($variation, $cart);
                        if ($checkChange['status']) {
                            $product->old_price = $checkChange['old_price'];
                        }
                    }
                    $products[] = $product;
                }
            }
        }
        return $products;
    }

    protected function updateChangePrice($variation, $cart)
    {
        $change = false;
        $old_price = 0;
        foreach ($cart as $value) {
            if ($variation->id == $value['variation_id']) {
                if ($variation->price2 != $value['price']) {
                    $old_price = $value['price'];
                    $change = true;
                    DB::table('carts')->where('id', $value['id'])->update([
                        'price' => $variation->price2
                    ]);
                }
            }
        }
        return ['status' => $change, 'old_price' => $old_price];
    }
}
