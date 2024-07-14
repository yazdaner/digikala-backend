<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Modules\sellers\App\Actions\UpdateInformation;
use Modules\sellers\App\Http\Requests\InformationRequest;
use Modules\sellers\App\Models\SellerBankCardNumber;

class RegisterContoller extends Controller
{
    public function addInfo(InformationRequest $request,UpdateInformation $updateInformation)
    {
        $username = $request->get('username');
        $cartNumber = $request->get('cartNumber');
        $nationalCode = $request->get('nationalCode');
        $brandName = $request->get('brandName');
        $seller = Seller::where([
            'username' => $username,
            'status' => -2,
        ])->whereNotNull('password')->first();
        if ($seller) {
            $seller->brandName = $brandName;
            $seller->update();
            $updateInformation([
                'nationalCode' => $nationalCode
            ],$seller->id);
            SellerBankCardNumber::where('seller_id',$seller->id)->delete();
        } else {
            return [
                'status' => 'error',
                'message' => 'فروشنده یافت نشد',
            ];
        }
    }

    public function finalStep()
    {
    }
}
