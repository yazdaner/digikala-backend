<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;

class EmptyCartController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        Cart::where([
            'user_id' => $user->id,
            'type' => $request->get('type'),
        ])->delete();
        return ['status' => 'ok'];
    }
}
