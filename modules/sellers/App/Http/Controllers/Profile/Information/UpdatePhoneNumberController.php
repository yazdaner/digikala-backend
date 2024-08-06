<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerInformation;

class UpdatePhoneNumberController extends Controller
{
    public function __invoke(Request $request)
    {
        $seller = $request->user();
        $this->validate(
            $request,
            [
                'phone-number' => ['required', 'numeric', 'digits:11'],
            ],
            [],
            [
                'phone-number' => 'شماره تلفن ثابت',
            ]
        );
        runEvent('seller:update-information', 'phone-number');
        SellerInformation::updateOrCreate([
            'seller_id' => $seller->id,
            'name' => 'verified-phone-number'
        ], [
            'value' => false
        ]);
        return ['status' => 'ok'];
    }
}
