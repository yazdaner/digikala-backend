<?php

namespace Modules\normaldelivery\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveNormalPostingSetting extends Controller
{
    public function __invoke(Request $request)
    {
        runEvent('setting:update-create', [
            'min_buy_free_normal_shipping' => $request->get('min_buy_free_normal_shipping'),
            'normal_delivery_time' => $request->get('normal_delivery_time'),
            'normal_shopping_cost' => $request->get('normal_shopping_cost'),
        ]);
        return ['status' => 'ok'];
    }
}
