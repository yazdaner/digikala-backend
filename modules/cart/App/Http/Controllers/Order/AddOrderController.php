<?php

namespace Modules\cart\App\Http\Controllers\Order;

use Modules\cart\App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;
use Modules\cart\App\Actions\AddOrder;
use Modules\cart\App\Actions\CartProducts;
use Modules\cart\App\Actions\AddSubmission;
use Modules\cart\App\Http\Requests\OrderRequest;


class AddOrderController extends Controller
{
    public function __invoke(
        OrderRequest $request,
        AddOrder $addOrder,
        AddSubmission $addSubmission
    ) {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)
            ->where('type', 1)
            ->pluck('count', 'variation_id');
        if(!defined('address_id')){
            define('address_id', $request->address_id);
        }
        $cartProducts = app(CartProducts::class);
        $products = $cartProducts($cart, [], $request);
        $submissions = getSubmissions($products);

        DB::beginTransaction();
        try {
            if (sizeof($submissions) > 0) {
                $order = $addOrder($request->all(), $submissions, $user);
                foreach ($submissions as $submission) {
                    $addSubmission($order, $submission, $user);
                }
                $payment = runEvent('request-payment', [
                    'price' => ($order->final_price * 10),
                    'type' => 'سفارش',
                    'callbackUrl' => url('order/verify'),
                    'table_id' => $order->id,
                    'table_type' => Order::class,
                ], true);
                runEvent('order:added', $order->id);
                DB::commit();
                return [
                    'status' => 'ok',
                    'paymentId' => $payment->id
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'موجودی کالاهایی که قصد سفارش آن را دارید تمام شده'
                ];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['status' => 'error'];
        }
    }
}
