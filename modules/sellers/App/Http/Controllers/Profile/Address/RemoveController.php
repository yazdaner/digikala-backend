<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerAddress;

class RemoveController extends Controller
{
    public function __invoke(Request $request,$id)
    {
        SellerAddress::where([
            'id' => $id,
            'seller_id' => $request->user()->id,
        ])->delete();
        return ['status' => 'ok'];
    }
}
