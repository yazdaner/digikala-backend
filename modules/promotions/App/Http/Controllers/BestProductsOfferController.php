<?php

namespace Modules\promotions\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\promotions\App\Models\Promotion;
use Modules\promotions\App\Models\PromotionProduct;

class BestProductsOfferController extends Controller
{
    public function __invoke(Request $request)
    {
        $time = time();
        $promotions = Promotion::where([
            'status' => 1,
            'type' => $request->get('type')
        ])->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->select(['id', 'end_time'])
            ->get();
        $promotionsId = $this->getPromotionsId($promotions);
        $items = PromotionProduct::whereIn('promotion_id', $promotionsId)
            ->orderBy('discount')
            ->limit($request->has('limit') ? $request->get('limit') : 10)
            ->select(['promotion_id', 'variation_id', 'id'])
            ->get();
        if (sizeof($items) > 0) {
            $variationsId = $this->getVariationsId($items);
            $variations = runEvent('variation:query', function ($query) use ($variationsId) {
                return $query->whereIn('id', $variationsId)
                    ->with('product', function ($build) {
                        return $build->select(['id', 'title', 'slug', 'image']);
                    })->get();
            }, true);
            return [
                'items' => $items,
                'variations' => $variations,
                'promotions' => $request->get('type') == 'amazing' ? $promotions : null
            ];
        } else {
            return [];
        }
    }

    private function getPromotionsId($promotions)
    {
        $result = [];
        foreach ($promotions as $promotion) {
            $result[] = $promotion->id;
        }
        return $result;
    }

    private function getVariationsId($items)
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = $item->variation_id;
        }
        return $result;
    }
}
