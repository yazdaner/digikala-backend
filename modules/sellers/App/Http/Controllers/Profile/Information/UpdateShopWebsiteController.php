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
                'wrb-url' => ['required', 'string', 'url'],
            ],
            [],
            [
                'wrb-url' => 'آدرس وب سایت',
            ]
        );
        runEvent('seller:update-information', 'wrb-url');
        return ['status' => 'ok'];
    }
}
