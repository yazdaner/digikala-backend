<?php

namespace Modules\products\App\Http\Actions;

use Illuminate\Http\Request;
use Modules\products\App\Models\Product;

class ProductPagination
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $products = Product::query();
        $products->with('variation');
        if(array_key_exists('sortBy',$data) && $data['sortBy'] != '')
        {
            $ar = explode('-',$data['sortBy']);
            if(sizeof($ar) == 2){
                $products->orderBy($ar[0],$ar[1]);
            }
        }
        else{
            $products->orderBy('id','DESC');
        }

        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $products->onlyTrashed();
        }

        if(array_key_exists('title',$data) && !empty($data['title']))
        {
            $products->where('title','like','%'.$data['title'].'%')
            ->orWhere('en_title','like','%'.$data['title'].'%');
        }


        if(array_key_exists('min_product_count',$data) && $data['min_product_count'] != '')
        {
            $products->where('product_count','>=',$data['min_product_count']);
        }

        if(array_key_exists('max_product_count',$data) && $data['max_product_count'] != '')
        {
            $products->where('product_count','<=',$data['max_product_count']);
        }

        $products = runEvent('admin-search-products',$products,true);
        $paginator = $products->paginate(10);
        $data = $paginator->makeVisible(['product_count','created_at','updated_at']);
        $paginator->data = $data;
        return $paginator;
    }
}

