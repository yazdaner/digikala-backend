<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerInformation;

class UpdateShopLogoController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate(
            $request,
            [
                'logo' => ['required', 'file', 'mimes:png,jpg,jpeg', 'max:512'],
            ],
            [],
            [
                'logo' => 'آیکون فروشگاه',
            ]
        );
        $path = upload_file($request, 'logo', 'sellers');
        $seller = $request->user();
        if ($path) {
            SellerInformation::updateOrCreate([
                'seller_id' => $seller->id,
                'name' => 'logo'
            ], [
                'value' => $path
            ]);
            return ['status' => 'ok'];
        } else {
            return ['status' => 'error'];
        }
    }
}
