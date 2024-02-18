<?php

namespace Modules\cart\App\Actions;

use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;

class AddProductToCartTable extends Controller
{
    public function __invoke($user_id,$variation,$count)
    {
        Cart::where([
             'user_id' => $user_id,
             'variation_id' => $variation->id,
        ])->delete();

        Cart::create([
            'user_id' => $user_id,
            'variation_id' => $variation->id,
            'count' => $count,
            'type' => 1,
            'price' => $variation->price2
        ]);
    }
}
// type = 1 => current cart
