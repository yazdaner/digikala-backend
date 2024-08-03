<?php

namespace Modules\categories\App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductSpecificationController extends Controller
{

    public function __invoke($product_id)
    {
        return runEvent('product:specifications',$product_id,true);
    }
}
