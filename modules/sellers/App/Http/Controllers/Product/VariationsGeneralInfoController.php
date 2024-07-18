<?php

namespace Modules\sellers\App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerProduct;

class VariationsGeneralInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        $seller = $request->user();
        $buyBoxVariationsCount = runEvent('variation:query', function ($query) use ($seller) {
            return $query
                ->where([
                    'seller_id' => $seller->id,
                    'selected_buy_box' => true
                ])->count();
        }, true);

        $variationsCount = runEvent('variation:query', function ($query) use ($seller) {
            return $query->where('seller_id', $seller->id)->count();
        }, true);

        $productsId = SellerProduct::where('seller_id', $seller->id)
            ->pluck('product_id')
            ->toArray();

        $hasCompetitor = runEvent('variation:query', function ($query) use ($seller, $productsId) {
            return $query->distinct('product_id')
                ->where('seller_id', '!=', $seller->id)
                ->whereIn('product_id', $productsId)
                ->count();
        }, true);

        $uniqueVariationsCount = runEvent('variation:query', function ($query) use ($seller) {
            return $query->distinct('product_id')
                ->where('seller_id', $seller->id)
                ->count();
        }, true);

        return [
            [
                'title' => 'تعداد کل تنوع ها',
                'value' => $variationsCount
            ],
            [
                'title' => 'تنوع های برنده شده باکس خرید',
                'value' => $buyBoxVariationsCount
            ],
            [
                'title' => 'تنوع های برنده نشده باکس خرید',
                'value' => ($variationsCount - $buyBoxVariationsCount)
            ],
            [
                'title' => 'تنوع های دارای رقیب',
                'value' => $hasCompetitor,
                'detail' => [
                    'حداقل یک فروشنده روی کالای مشابه قیمت گذاری کرده است'
                ]
            ],
            [
                'title' => 'تنوع های بدون رقیب',
                'value' => ($uniqueVariationsCount - $hasCompetitor),
                'detail' => [
                    'تنوع های که در حال حاضر شما تنها فروشنده آن هستید'
                ]
            ],
        ];
    }
}
