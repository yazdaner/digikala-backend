<?php

namespace Modules\products\App\Actions;

use Illuminate\Http\Request;
use Modules\products\App\Models\Product;

class CreateProduct
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        if(auth()->check() && auth()->user()->role != 'admin')
        {
            if(array_key_exists('status',$data)){
                unset($data['status']);
            }
            $data['status'] = -3;
        }
        $product = new Product($data);
        $product->fake = $request->fake ?? 0;
        $product->slug = replaceSpace($request->en_title);
        $product->saveOrFail();

        $addKeywords = app(AddKeywords::class);
        $addKeywords($product,$request);

        runEvent('product:created',$product);
        return ['status' => 'ok'];

    }

}

