<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateShopAboutController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate(
            $request,
            [
                'shop_about' => ['required', 'string', 'max:255'],
            ],
            [],
            [
                'shop_about' => 'درباره فروشگاه',
            ]
        );
        runEvent('seller:update-information', 'shop_about');
        return ['status' => 'ok'];
    }
}
