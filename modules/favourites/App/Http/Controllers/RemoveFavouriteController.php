<?php

namespace Modules\favourites\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Favourite;

class RemoveFavouriteController extends Controller
{
    public function __invoke($product_id,Request $request)
    {
        $user = $request->user();
        Favourite::where([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ])->delete();
        return ['status' => 'ok'];
    }
}
