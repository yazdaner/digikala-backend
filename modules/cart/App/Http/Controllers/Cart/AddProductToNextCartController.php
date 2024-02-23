<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;

class AddProductToNextCartController extends Controller
{
    public function __invoke(Request $request)
    {
        $variationId = $request->get('variationId');
        Cart::where([
            'user_id' => $request->user()->id,
            'type' => 1,
            'variation_id' => $variationId
        ])->update([
            'type' => 2
        ]);
        return ['status' => 'ok'];
    }
}
