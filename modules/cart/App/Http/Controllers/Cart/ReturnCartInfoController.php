<?php

namespace Modules\cart\App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\CartProducts;

class ReturnCartInfoController extends Controller
{
    protected array $cart = [];
    public function __invoke(Request $request, CartProducts $cartProducts)
    {
        if (auth()->check()) {
            $this->cart = Cart::where('user_id', auth()->id())
                ->get()
                ->toArray();
        }
        $currentCart = $this->getCurrentCart($request);
        $nextCart = $this->getNextCart();
        $cartData = [
            'current' => [
                'products' => []
            ],
            'next' => [
                'products' => []
            ],
        ];
        if (is_array($currentCart)) {
            $cartData['current']['products'] = $cartProducts(
                $currentCart,
                $this->cart,
                $request
            );
        }

        if (is_array($nextCart)) {
            $cartData['next']['products'] = $cartProducts(
                $nextCart,
                $this->cart,
                $request
            );
        }

        return $cartData;
    }
    protected function getCurrentCart($request)
    {
        if (auth()->check()) {
            $cart = array_filter($this->cart, function ($row) {
                return ($row['type'] == 1);
            });
            $result = [];
            foreach ($cart as $value) {
                $result[$value['variation_id']] = $value['count'];
            }
            return $result;
        } else {
            return $request->get('cart');
        }
    }
    protected function getNextCart()
    {
        if (auth()->check()) {
            $cart = array_filter($this->cart, function ($row) {
                return ($row['type'] == 2);
            });
            $result = [];
            foreach ($cart as $value) {
                $result[$value['variation_id']] = $value['count'];
            }
            return $result;
        } else {
            return [];
        }
    }
}
