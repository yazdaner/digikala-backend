<?php

namespace Modules\sellers\App\Events;

use Modules\sellers\App\Models\SellerInformation;

class UpdateSellerInformation
{
    public function handle($key)
    {
        $request = request();
        $seller = $request->user();
        SellerInformation::updateOrCreate([
            'seller_id' => $seller->id,
            'name' => $key
        ],[
            'value' => $request->get($key)
        ]);
    }
}
