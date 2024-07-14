<?php

namespace Modules\sellers\App\Actions;

use Illuminate\Http\Request;
use Modules\sellers\App\Models\SellerBankCardNumber;

class AddBankCartNumber
{
    public function __invoke($cartNumber, $sellerId)
    {
        if (trim($cartNumber) != '' && strlen($cartNumber) == 16)
        {
            SellerBankCardNumber::create([
                'number' => $cartNumber,
                'seller_id' => $sellerId
            ]);
        }
    }
}
