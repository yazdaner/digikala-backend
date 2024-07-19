<?php

namespace Modules\sellers\App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Modules\sellers\App\Models\SellerProduct;

class SellerProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        return runEvent('product:query', function ($query) use ($request) {
            $seller = $request->user();
            $query = $query->with(['category', 'brand'])
                ->withCount(['variations' => function (Builder $builder) use ($seller) {
                    return $builder->where('seller_id', $seller->id);
                }]);
            if ($request->has('category_id') && !empty($request->get('category_id'))) {
                $categoriesId = getChildCategoriesId($request->get('category_id'));
                $query = $query->whereIn('category_id', $categoriesId);
            }
            if ($request->has('status') && !empty($request->get('status'))) {
                $query = $query->where('status', $request->get('status'));
            }
            if ($request->has('authenticity') && $request->get('authenticity') == 'fake') {
                $query = $query->where('fake', true);
            }
            if ($request->has('authenticity') && $request->get('authenticity') == 'original') {
                $query = $query->where('fake', false);
            }
            $productsId = SellerProduct::where('seller_id', $seller->id)
                ->pluck('product_id')
                ->toArray();
            $query = $query->whereIn('id', $productsId);
            return $query->paginate(env('PAGINATE'));
        }, true);
    }
}
