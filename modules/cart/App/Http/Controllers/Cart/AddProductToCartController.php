<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\AddProductToCartTable;

class AddProductToCartController extends Controller
{
    public function __invoke(Request $request, AddProductToCartTable $addProductToCartTable)
    {
        $count = $request->get('count');
        $variationId = $request->get('variationId');
        $variation = runEvent('check-variation-for-buy', [
            'id' => $variationId,
            'count' => $count,
        ], true);
        if ($variation && is_object($variation)) {
            if (auth()->check()) {
                $addProductToCartTable(
                    user_id: $request->user()->id,
                    variation: $variation,
                    count: $count,
                );
            }
            return ['status' => 'ok', 'variation' => $variation];
        } else {
            return ['status' => 'error'];
        }
    }
}
