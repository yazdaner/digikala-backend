<?php

namespace Modules\shop\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\shop\Queries\Products;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function products(Request $request)
    {
        $data = $request->all();
        $data['status'] = 1;
        $products = new Products($data);
        return $products->result();
    }
}
