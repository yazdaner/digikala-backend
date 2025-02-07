<?php

namespace Modules\discounts\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\discounts\App\Models\Discount;
use SebastianBergmann\CodeUnit\FunctionUnit;

class CheckDiscountCodeController extends Controller
{
    protected array $products = [];
    protected array $variations = [];
    protected array $grouped = [];

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
                    $this->grouped[] =
                        [
                            'category_id' => $discount->category_id,
                            'variationsId' => $this->getVariationsIdBasedCategory(
                                $discount->category_id
                            ),
                            'discount' => $discount
                        ];
                }
                $discountAmount = $this->getDiscountAmount();
                return ['discount' => $discountAmount];
            }
        }
        return $result;
    }

    protected function getDiscountAmount()
    {
        $discountAmount = 0;
        foreach ($this->grouped as $i => $group) {
            $this->grouped[$i]['totalPrice'] =
                $this->getVariationsTotalPrice($group['variationsId']);
            $amount = $this->getGruopDiscountAmount($group);
            if (
                $group['totalPrice'] > 0 &&
                ($group['discount']->min_perchase == 0 ||
                    intval($group['totalPrice']) >=
                    intval($group['discount']->min_perchase))
            ) {
                unset($this->grouped[$i]);
                if ($amount > 0) {
                    $this->removeVariationsIdOfGroups($group);
                    $discountAmount += $amount;
                }
            }
        }
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

    protected function getVariationsTotalPrice($variationsId)
    {
        $totalPrice = 0;
        foreach ($variationsId as $id) {
            $totalPrice += $this->variations[$id]->price2;
        }
        return $totalPrice;
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

    protected function removeVariationsIdOfGroups($data)
    {
        foreach ($data['variationsId'] as $id) {
            foreach ($this->grouped as $key => $group) {
                if ($index = array_search($id, $group['variationsId']) !== false) {
                    unset($this->grouped[$key]['variationsId'][$index]);
                }
            }
        }
    }
}
