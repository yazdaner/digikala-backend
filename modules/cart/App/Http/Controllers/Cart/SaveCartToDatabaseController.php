<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\AddProductToCartTable;

class SaveCartToDatabaseController extends Controller
{
    public function __invoke(Request $request, AddProductToCartTable $addProductToCartTable)
    {
        $cart = $request->post('cart');
        if (is_array($cart)) {
            foreach ($cart as $variationId => $count) {
                $variation = runEvent('check-variation-for-buy',[
                    'id' => $variationId,
                    'count' => $count,
                ],true);
                if($variation && is_object($variation)){
                    $addProductToCartTable(
                        $request->user()->id,
                        $variation,
                        $count
                    );
                } else {
                    return ['status' => 'error'];
                }
            }
        }
        return ['status' => 'ok'];
    }
}
