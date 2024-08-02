<?php

namespace Modules\promotions\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ProductsListController extends Controller
{
    public function __invoke(Request $request)
    {
        return runEvent('variation:query',function ($query) use ($request){
            $timestamp = strtotime('-30 days');
            $query->withSum(['variation_sales' => function(Builder $builder) use ($timestamp){
                $builder->where('created_at','>=',$timestamp);
            }],'count')
            ->whereHas('product')
            ->with('product');
            $category_id = $request->get('category_id');
            if($category_id > 0){
                define('productCategories_local_key','product_id');
                $query->whereHas('productCategories',function (Builder $builder) use ($category_id){
                    $builder->where('category_id',$category_id);
                });
            }
            return $query->paginate(env('PAGINATE'));
        },true);
    }
}
