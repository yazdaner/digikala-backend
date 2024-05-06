<?php

namespace Modules\cart\App\Actions;

use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;
use Modules\cart\App\Http\Requests\OrderRequest;

class AddSubmission extends Controller
{
    public function __invoke(
        OrderRequest $request,
        AddOrder $addOrder,
        AddSubmission $addSubmission
    ) {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)
            ->where('type', 1)
            ->pluck('count', 'variation_id');
        define('address_id',$request->get(address_id));

        $cartProducts = app(CartProducts::class);
        $products = $cartProducts($cart, [], $request);
        $submissions = getSubmissions($products);
    }
}
