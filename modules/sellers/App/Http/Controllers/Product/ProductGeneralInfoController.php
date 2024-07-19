<?php

namespace Modules\sellers\App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\sellers\App\Models\SellerProduct;

class ProductGeneralInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        $timestamp = strtotime('-30 days');
        $seller = $request->user();
        $last30DaysProductCount = SellerProduct::where('seller_id',$seller->id)
        ->where('created_at','>=',$timestamp)->count();
    
        $totalProducts = SellerProduct::where('seller_id',$seller->id)->count();

        $awaiting = runEvent('product:query',function ($query) use ($seller){
            return $query->where([
                'seller_id' => $seller->id,
                'status' => -3,
            ])->count();
        },true);

        $review = runEvent('product:query',function ($query) use ($seller){
            return $query->where([
                'seller_id' => $seller->id,
                'status' => -5,
            ])->count();
        },true);

        $failed = runEvent('product:query',function ($query) use ($seller){
            return $query->where([
                'seller_id' => $seller->id,
                'status' => -4,
            ])->count();
        },true);

        return [
            'failed' => $failed,
            'review' => $review,
            'awaiting' => $awaiting,
            'totalProducts' => $totalProducts,
            'last30DaysProductCount' => $last30DaysProductCount,
        ];
    }
}
