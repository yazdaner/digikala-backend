<?php

namespace Modules\shop\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\shop\Queries\Products;
use App\Http\Controllers\Controller;

use function Laravel\Prompts\select;

class ShopController extends Controller
{
    public function products(Request $request)
    {
        $data = $request->all();
        $data['status'] = 1;
        $products = new Products($data);
        return $products->result();
    }

    public function categoriesData(Request $request)
    {
        $ids = $request->get('ids');
        $array = explode(',', $ids);
        return runEvent('category:query', function ($query) use ($array) {
            return $query->whereIn('id', $array)
                ->select(['name','slug','image','parent_id'])->get();
        },true);
    }
}
