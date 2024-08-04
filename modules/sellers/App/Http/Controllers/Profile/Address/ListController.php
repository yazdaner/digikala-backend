<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerAddress;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $addresses = SellerAddress::query();
        $addresses->orderBy('id', 'DESC')
            ->with('city')
            ->where([
                'type' => $request->get('type'),
                'seller_id' => $request->user()->id
            ]);
        if ($request->has('paginate')) {
            return $addresses->paginate(env('PAGINATE'));
        } else {
            return $addresses->get();
        }
    }
}
