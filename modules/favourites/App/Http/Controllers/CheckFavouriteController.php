<?php

namespace Modules\favourites\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\favourites\App\Models\Favourite;

class CheckFavouriteController extends Controller
{
    public function __invoke($product_id,Request $request)
    {
        $user = $request->user();
        $favourite = Favourite::where([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ])->first();
        if($favourite){
            return ['added' => 'true'];
        }else{
            return ['added' => 'false'];
        }
    }
}
