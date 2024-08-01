<?php

namespace Modules\promotions\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\promotions\App\Models\Promotion;
use Modules\promotions\App\Models\PromotionProduct;
use Modules\promotions\App\Http\Requests\AddProductsRequest;

class AddProductsPromotionController extends Controller
{
    public function __invoke(AddProductsRequest $request)
    {
        DB::beginTransaction();
        try {
            $promotion = Promotion::findOrFail(
                $request->get('promotion_id')
            );
            $products = $request->get('products', []);
            PromotionProduct::where([
                'promotion_id' => $promotion->id
            ])->delete();
            foreach ($products as $product) {
                PromotionProduct::create([
                    'promotion_id' => $promotion->id,
                    'variation_id' => $product['variation_id'],
                    'original_price' => $product['original_price'],
                    'original_count' => $product['original_count'],
                    'count' => $product['count'],
                    'discount' => $product['percent'],
                ]);
                $this->updateVariation($product);
            }
            DB::commit();
            return ['status' => 'ok'];
        } catch (\Exception $ex) {
            DB::rollBack();
            // \Log::info($ex->getMessage());
            // \Log::info($ex->getLine());
            // \Log::info($ex->getLine());
            return ['status' => 'error'];
        }
    }

    private function updateVariation($data)
    {
        runEvent('variation:query', function ($query) use ($data) {
            $discount = intval(($data['percent'] * $data['original_price']) / 100);
            $price2 = $data['original_price'] - $discount;
            $query->where('id', $data['variation_id'])
                ->update([
                    'price1' => $data['original_price'],
                    'price2' => $price2,
                    'product_count' => $data['count']
                ]);
        });
    }
}
