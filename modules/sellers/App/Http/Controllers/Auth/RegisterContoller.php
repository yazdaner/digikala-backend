<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Actions\AddAddress;
use Modules\sellers\App\Models\Seller;
use Modules\sellers\App\Actions\AddBankCartNumber;
use Modules\sellers\App\Actions\UpdateInformation;
use Modules\sellers\App\Models\SellerBankCardNumber;
use Modules\sellers\App\Http\Requests\AddressRequest;
use Modules\sellers\App\Http\Requests\InformationRequest;

class RegisterContoller extends Controller
{
    public function addInfo(
        InformationRequest $request,
        UpdateInformation $updateInformation,
        AddBankCartNumber $addBankCartNumber
    ) {
        $username = $request->get('username');
        $cartNumber = $request->get('cartNumber');
        $nationalCode = $request->get('nationalCode');
        $brandName = $request->get('brandName');

        $seller = Seller::where([
            'username' => $username,
            'status' => -2,
        ])->whereNotNull('password')->first();
        if ($seller) {
            $sellerId = $seller->id;
            $seller->brandName = $brandName;
            $seller->update();
            $updateInformation([
                'nationalCode' => $nationalCode
            ], $sellerId);
            SellerBankCardNumber::where('seller_id', $sellerId)->delete();
            $addBankCartNumber($cartNumber, $sellerId);
            return ['status' => 'ok'];
        } else {
            return [
                'status' => 'error',
                'message' => 'فروشنده یافت نشد',
            ];
        }
    }

    public function finalStep(AddressRequest $request,AddAddress $addAddress)
    {

    }
}
