<?php

namespace Modules\discounts\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\discounts\App\Models\Discount;

class CheckDiscountCodeController extends Controller
{
    protected $products = [];
    protected $variations = [];
    protected $grouped = [];

    public function __invoke(Request $request)
    {
        $result = ['status' => 'error'];
        $request->validate(['code' => 'required|string'], [], [
            'code' => 'کد تخفیف'
        ]);
        $discounts = Discount::where('code', $request->post('code'))
            ->where('expiration_date', '>=', time())
            ->orderBy('min_purchase', 'DESC')
            ->get();
        if (sizeof($discounts)) {
            $cartItems = runEvent('cart:items', 1, true);
            if (sizeof($cartItems) > 0) {
                $this->variations = $this->getVariations($cartItems);
                $this->products = $this->getProducts($this->variations);
                foreach ($discounts as $discount) {
                    $variationsId = $this->getVariationsIdBasedCategory(
                        $discount->category_id
                    );
                    $this->grouped[] =
                        [
                            'category_id' => $discount->category_id,
                            'variationsId' => $variationsId,
                            'totalPrice' => $this->getVariationsTotalPrice(
                                $variationsId
                            ),
                            'discount' => $discount
                        ];
                }
                $discountAmount = 0;
                $i = 0;
                while (sizeof($this->grouped) > 0) {
                    $amount = $this->getGruopDiscountAmount(
                        $this->grouped[$i]
                    );
                    if ($this->grouped[$i]['discount']->min_perchase > 0) {
                        if (
                            intval($this->grouped[$i]['totalPrice']) <
                            intval($this->grouped[$i]['discount']->min_perchase)
                        ) {
                            $amount = 0;
                        }
                    }
                    if ($amount > 0) {
                        $discountAmount += $amount;
                    }
                    unset($this->grouped[$i]);
                }


                return ['discount' => $discountAmount];
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

    protected function getVariationsIdBasedCategory($category_id)
    {
        if ($category_id == 0) {
            return array_keys($this->variations);
        } else {
            $productsId = array_keys(array_filter($this->products, function ($value) use ($category_id) {
                return $value == $category_id;
            }));
            return array_filter($this->variations, function ($variation) use ($productsId) {
                return array_key_exists($variation->product_id, $productsId);
            });
        }
    }

    protected function getGruopDiscountAmount($data)
    {
        $amount = 0;
        if (intval($data['discount']->amount) > 0) {
            $amount = intval($data['discount']->amount);
        } else {
            $amount = ($data['totalPrice'] * intval($data['discount']->percent) / 100);
        }
        if (intval($data['discount']['max_amount']) > $amount) {
            $amount = $data['discount']['max_amount'];
        }
        return intval($amount);
    }
}
