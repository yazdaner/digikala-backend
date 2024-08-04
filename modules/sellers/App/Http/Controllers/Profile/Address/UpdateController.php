<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Address;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerAddress;
use Modules\sellers\App\Http\Requests\AddressRequest;

class UpdateController extends Controller
{
    public function __invoke(AddressRequest $request, $id)
    {
        $address = SellerAddress::where([
            'id' => $id,
            'seller_id' => $request->user()->id,
        ])->firstOrFail();

        if (
            $address->latitude != $request->get('latitude') ||
            $address->longitude != $request->get('longitude')
        ) {
            runEvent('CreateStaticMap', $address->id);
        }
        if (strval($request->get('warehouse')) == 'true') {
            $address->type = 'warehouse';
        }else{
            $address->type = 'warehouse';
            $address->warehouse_name = null;
        }
        $address->update($request->all());
        return ['status' => 'ok'];
    }
}
