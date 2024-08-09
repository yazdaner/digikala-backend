<?php

namespace Modules\zarinpal\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GatewayController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->method() == 'POST') {
            $this->validate($request, [
                'MerchantId' => ['required', 'string']
            ]);
            runEvent('setting:update-create', [
                'MerchantId' => $request->get('MerchantId')
            ]);
            return ['status' => 'ok'];
        } else {
            return [
                'MerchantId' => runEvent('setting:value', 'MerchantId', true)
            ];
        }
    }
}
