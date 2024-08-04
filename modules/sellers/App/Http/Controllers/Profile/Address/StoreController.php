<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Address;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Http\Requests\AddressRequest;
use Modules\sellers\App\Models\SellerAddress;

class StoreController extends Controller
{
    public function __invoke(AddressRequest $request)
    {
        $address = new SellerAddress($request->validated());
    }
}
