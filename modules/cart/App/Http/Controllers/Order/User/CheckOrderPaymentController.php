<?php

namespace Modules\cart\App\Http\Controllers\Order\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Order;

class CheckOrderPaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $orderId = $request->get('orderId');
        $result = ['status' => 'error'];
        $order = Order::where([
            'id' => $orderId,
            'user_id' => $request->user()->id
        ])->first();
        if ($order && $order->status >= 5) {
            $result = [
                'status' => 'ok',
                'order_id' => $order->id,
                'payment_method' =>  $order->payment_method
            ];
        }
        return $result;
    }
}
