<?php

namespace Modules\productcomparison\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompareProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        $result = [];
        $productsId = $request->get('product_id');
        foreach ($productsId as $id) {
            $product = runEvent('product:query', function ($query) use ($id) {
                return $query->where('id',$id)->with('variation')->first();
            }, true);
            if($product){
                $specifications = runEvent('product:specifications',$id,true);
                $result[]=[
                    'product' => $product,
                    'specifications' => $specifications
                ];
            }
        }
        return $result;
    }
}
