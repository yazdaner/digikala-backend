<?php

namespace Modules\cart\App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\CartProducts;

class ReturnSubmissionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where(['user_id', $user->id, 'type' => 1])
            ->pluck('count', 'variation_id');
        define('address_id',$request->address_id);
        $cartProducts = app(CartProducts::class);
        $products = $cartProducts($cart,[],$request);
        $shippingMethods = config('app.shipping-methods');
    }
}
