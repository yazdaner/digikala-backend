<?php

namespace Modules\setting\App\Http\Controllers;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function __invoke()
    {
        return config('shop-info');
    }
}
