<?php

namespace Modules\favourites\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\cart\App\Models\Favourite;

class AddFavouriteController extends Controller
{
    public function __invoke($product_id,Request $request)
    {
        $user = $request->user();
        Favourite::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ],[]);
        return ['status' => 'ok'];
    }
}
