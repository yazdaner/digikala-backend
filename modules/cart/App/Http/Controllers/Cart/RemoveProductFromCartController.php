<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;

class RemoveProductFromCartController extends Controller
{
    public function __invoke(Request $request)
    {
        $variationId = $request->get('variationId');
        Cart::where([
            'variation_id' => $variationId,
            'user_id' => $request->user()->id
        ])->delete();
        return ['status' => 'ok'];
    }
}
