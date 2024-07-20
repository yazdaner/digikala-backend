<?php

namespace Modules\sellers\App\Events;

use Illuminate\Support\Facades\Auth;

class AddSellerIdToVariation
{
    public function handle($variation)
    {
        if(Auth::guard('seller')->check()){
            $seller = Auth::guard('seller')->user();
            $variation->seller_id = $seller->id;
        }
        return $variation;
    }
}
