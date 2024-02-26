<?php

namespace Modules\normaldelivery\App\Http\Controllers;

use App\Http\Controllers\Controller;

class NormalPostingSetting extends Controller
{
    public function __invoke()
    {
        return [
            'min_buy_free_normal_shopping' => runEvent(
                'setting:value',
                'min_buy_free_normal_shopping',
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
