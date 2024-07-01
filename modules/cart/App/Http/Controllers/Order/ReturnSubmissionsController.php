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
        $result = [];
        $user = $request->user();
        $cart = Cart::where(['user_id' => $user->id, 'type' => 1])
            ->pluck('count', 'variation_id');
        if(!defined('address_id')){
            define('address_id', $request->address_id);
        }
        $cartProducts = app(CartProducts::class);
        $products = $cartProducts($cart, [], $request);
        $submissions = getSubmissions($products);
        $totalProducts = sizeof($products);
        $submissionTotalProduct = 0;
        foreach ($submissions as $submission) {
            $submissionTotalProduct += sizeof($submission['products']);
        }
        $result['submission'] = $submissions;
        $result['count'] = $submissionTotalProduct;

        if ($totalProducts != $submissionTotalProduct) {
            $result['error_message'] = 'با توجه به آدرس انتخابی برخی محصولات حذف شدن';
        }
        return $result;
    }
}
