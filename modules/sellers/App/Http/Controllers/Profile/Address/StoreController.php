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
        $address->seller_id = $request->user()->id;
        if (strval($request->get('warehouse')) == 'true') {
            $address->type = 'warehouse';
        }else{
            $address->type = 'shop';
        }
        $address->saveOrFail();
        runEvent('CreateStaticMap',$address->id);
        return ['status' => 'ok'];
    }
}
