<?php

namespace Modules\products\App\Http\Actions;

use Illuminate\Http\Request;
use Modules\products\App\Models\Product;

class UpdateProduct
{
    public function __invoke(Request $request,$id)
    {
        $data = $request->all();
        if(auth()->check() && auth()->user()->role != 'admin')
        {
            if(array_key_exists('status',$data)){
                unset($data['status']);
            }
            $data['status'] = -3;
        }
        $data['fake'] = $request->fake ?? 0;
        $product = Product::findOrFail($id);
        $product->slug = replaceSpace($request->en_title);
        $product->update($data);
        runEvent('product.updated',$product);
        return ['status' => 'ok'];

    }

}

