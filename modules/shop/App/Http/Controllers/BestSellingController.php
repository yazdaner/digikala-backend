<?php

namespace Modules\shop\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class BestSellingController extends Controller
{
    public function __invoke(Request $request)
    {
        $period = $request->get('period');
        $category_id = $request->get('category_id');
        $timestamp = strtotime('-30 days');
        if ($period == 'week') {
            $timestamp = strtotime('-1 week');
        }
        $productsId = runEvent('query:product-sales-statistics', function ($query) use ($timestamp) {
            return $query->select(
                'product_id',
                DB::raw('SUM(order_count) as count')
            )
                ->where('created_at', '>=', $timestamp)
                ->orderBy('count', 'DESC')
                ->groupBy('product_id')
                ->pluck('product_id')
                ->toArray();
        }, true);
        if (is_array($productsId)) {
            return runEvent('product:query', function ($query) use ($productsId,$category_id) {
                $idsString = implode(',',$productsId);
                $query
                    ->whereIn('id', $productsId)
                    ->where('status', 1)
                    ->whereHas('variation')
                    ->with('variation')
                    ->orderByRaw("FIELD(id,$idsString)");
                if ($category_id != 0) {
                    $query->whereHas('categories', function (Builder $builder) use ($category_id) {
                        return $builder->where('category_id', $category_id);
                    });
                }
                return $query->limit(50)->get();
            }, true);
        } else {
            return [];
        }
    }
}
