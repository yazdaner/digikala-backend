<?php

namespace Modules\favourites\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Favourite;

class UserFavouriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $products_id = Favourite::where('user_id', $request->user()->id)
            ->orderBy('id', 'DESC')
            ->pluck('product_id')
            ->toArray();

        return runEvent('product:query', function ($query) use ($products_id) {
            return $query->whereIn('id',$products_id)
            ->with('variation')
            ->paginate(50);
        }, true);
    }
}
