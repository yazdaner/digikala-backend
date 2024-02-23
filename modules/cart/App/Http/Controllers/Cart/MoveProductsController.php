<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;

class MoveProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $user = $request->user();
        Cart::where([
            'user_id' => $user->id,
            'type' => $from,
        ])->update([
            'type' => $to
        ]);
        return ['status' => 'ok'];
    }
}
