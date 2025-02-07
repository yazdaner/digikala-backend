<?php

namespace Modules\sellers\App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\Seller;
use Modules\sellers\App\Actions\AddBankCartNumber;
use Modules\sellers\App\Actions\UpdateInformation;
use Modules\sellers\App\Models\SellerBankCardNumber;
use Modules\sellers\App\Http\Requests\InformationRequest;

class RegisterAddInfoController extends Controller
{
    public function __invoke(
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
        ])->whereNotNull('password')->firstOrFail();
        DB::beginTransaction();
        try {
            $sellerId = $seller->id;
            $seller->brandName = $brandName;
            $seller->status = -1;
            $seller->update();
            $updateInformation([
                'nationalCode' => $nationalCode
            ], $sellerId);
            SellerBankCardNumber::where('seller_id', $sellerId)->delete();
            $addBankCartNumber($cartNumber, $sellerId);
            DB::commit();
            return ['status' => 'ok'];
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['status' => 'error'];
        }
    }
}
