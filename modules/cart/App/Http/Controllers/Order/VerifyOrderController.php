<?php

namespace Modules\cart\App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Cart;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Submission;

class VerifyOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $payment = runEvent('verify-payment', $request, true);
        if (
            is_object($payment) &&
            $payment->status == 'ok' &&
            $payment->table_type == Order::class
        ) {
            $order = Order::where([
                'status' => 0,
                'id' => $payment->table_id
            ])->firstOrFail();
            $order->status = 5;
            $order->update();
            Submission::where('order_id',$order->id)->update([
                'status' => 5,
            ]);
            Cart::where(['user_id'=>$order->user_id,'type'=>1])->delete();
            runEvent('order:verified',$order);
            return redirect(env('APP_URL').'/verify/checkout'.$order->id);
        }else{
            return redirect(env('APP_URL').'/verify/checkout');
        }
    }
}
