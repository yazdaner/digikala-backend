<?php

namespace Modules\discounts\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\discounts\App\Models\Discount;

class CheckDiscountCodeController extends Controller
{
    protected $products = [];
    protected $variations = [];

    public function __invoke(Request $request)
    {
        $result = ['status' => 'error'];
        $request->validate(['code' => 'required|string'], [], [
            'code' => 'کد تخفیف'
        ]);
        $discounts = Discount::where('code', $request->post('code'))
            ->where('expiration_date', '>=', time())
            ->orderBy('amount', 'DESC')
            ->get();
        if (sizeof($discounts)) {
            $cartItems = runEvent('cart:items', 1, true);
            if (sizeof($cartItems) > 0) {
                $this->variations = $this->getVariations($cartItems);
                $this->products = $this->getProducts($this->variations);
                $grouped = [];
                foreach ($discounts as $discount) {
                    $grouped[$discount->category_id] =
                        $this->getVariationsIdBasedCategory($discount->category_id);
                }
            }
        }
        return $result;
    }

    protected function getVariations($cartItems)
    {
        $variationsId = array_keys($cartItems);
        return runEvent('variation:query', function ($query) use ($variationsId) {
            return $query->whereIn('id', $variationsId)
                ->get()
                ->keyBy('id');
        }, true);
    }

    protected function getProducts($variations)
    {
        $productsId = [];
        foreach ($variations as $variation) {
            $productsId[] = $variation->product_id;
        }
        return runEvent('product:query', function ($query) use ($productsId) {
            return $query->whereIn('id', $productsId)
                ->pluck(['id', 'category_id'])
                ->toArray();
        }, true);
    }
}
