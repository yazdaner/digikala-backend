<?php

namespace Modules\sellers\App\Http\Controllers\Profile\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateShopWebsiteController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate(
            $request,
            [
                'shop_website' => ['required', 'string', 'url'],
            ],
            [],
            [
                'shop_website' => 'آدرس وب سایت',
            ]
        );
        runEvent('seller:update-information', 'shop_website');
        return ['status' => 'ok'];
    }
}
