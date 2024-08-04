<?php

namespace Modules\sellers\App\Actions;

use Modules\sellers\App\Models\SellerAddress;
use Modules\sellers\App\Http\Requests\RegisterFinalStepRequest;

class AddAddress
{
    public function __invoke($seller, RegisterFinalStepRequest $request)
    {
        $addressInfo = $request->get('addressInfo');
        SellerAddress::where('seller_id', $seller->id)->delete();
        if (is_array($addressInfo)) {
            $addressInfo['seller_id'] = $seller->id;
            $address = SellerAddress::create($addressInfo);
            runEvent('CreateStaticMap', $address->id);
        }
    }
}
