<?php

namespace Modules\cart\App\Events;

use Modules\cart\App\Models\Cart;

class CartItems
{
    public function handle($type = 1)
    {
        $user = request()->user();
        return Cart::where([
            'user_id' => $user->id,
            'type' => $type
        ])->pluck('count','variation_id')->toArray();
    }
}
