<?php

namespace Modules\cart\App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\CartProducts;

class ReturnSubmissionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where(['user_id' => $user->id, 'type' => 1])
            ->pluck('count', 'variation_id');
        define('address_id', $request->address_id);
        $cartProducts = app(CartProducts::class);
        $products = $cartProducts($cart, [], $request);
        $shippingMethods = config('app.shipping-methods');
        usort($shippingMethods, function ($item1, $item2) {
            $p1 = array_key_exists('priority', $item1) ? $item1['priority'] : 10;
            $p2 = array_key_exists('priority', $item2) ? $item2['priority'] : 10;
            return ($p1 - $p2);
        });
        $submissions = [];
        $submissionTotalProduct = 0;
        $senders = getSenders($products);
        foreach ($senders as $sender) {
            foreach ($shippingMethods as $method) {
                $submission = runEvent($method['event'], [
                    'products' => $products,
                    'sender' => $sender
                ],true);
                if (is_array($submission) && array_key_exists('selected_keys', $submission) && sizeof($submission['products']) > 0) {
                    foreach ($submission['selected_keys'] as $key) {
                        unset($products[$key]);
                    }
                    $submissions[] = $submission;
                    $submissionTotalProduct += sizeof($submission['products']);
                }
            }
        }
        $result = [];
        $totalProducts = sizeof($products);

        $result['submission'] = $submissions;
        $result['count'] = $submissionTotalProduct;

        if ($totalProducts != $submissionTotalProduct) {
            $result['error_message'] = 'با توجه به آدرس انتخابی برخی محصولات حذف شدن';
        }
        return $result;
    }
}
