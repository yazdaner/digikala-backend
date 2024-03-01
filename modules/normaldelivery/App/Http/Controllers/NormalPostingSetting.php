<?php

namespace Modules\normaldelivery\App\Http\Controllers;

use App\Http\Controllers\Controller;

class NormalPostingSetting extends Controller
{
    public function __invoke()
    {
        return [
            'min_buy_free_normal_shipping' => runEvent(
                'setting:value',
                'min_buy_free_normal_shipping',
                true
            ),
            'normal_delivery_time' => runEvent(
                'setting:value',
                'normal_delivery_time',
                true
            ),
            'normal_shopping_cost' =>  runEvent(
                'setting:value',
                'normal_shopping_cost',
                true
            ),
        ];
    }
}
