<?php

namespace Modules\sellers\App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllProductController extends Controller
{
    public function __invoke(Request $request)
    {
        return runEvent('product:query', function ($query) use ($request) {
            $tag = trim($request->get('tag'));
            $query->with(['variation', 'category'])
                ->withCount('variations')
                ->withCount('product_seller');
            if ($request->has('category_id') && !empty($request->get('category_id'))) {
                $categoriesId = getChildCategoriesId($request->get('category_id'));
                $query->whereIn('category_id', $categoriesId);
            }
            if ($request->has('brand_id') && !empty($request->get('brand_id'))) {
                $query->where('brand_id', $request->get('brand_id'));
            }
            if ($tag != '' && $tag != null) {
                $productsId = runEvent('product:id-based-tag', $tag, true);
                $query->whereIn('id', $productsId);
            }
            return $query->paginate(env('PAGINATE'));
        }, true);
    }
}
