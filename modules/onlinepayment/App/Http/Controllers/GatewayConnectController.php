<?php

namespace Modules\onlinepayment\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\onlinepayment\App\Models\Payment;

class GatewayConnectController extends Controller
{
    public function __invoke(Request $request)
    {
        $paymentId = $request->paymentId;
        $payment = Payment::where([
            'id' => $paymentId,
            'status' => 'suspended'
        ])->firstOrFail();
        $result = runEvent("connect-$payment->gateway-gateway", $payment, true);
        if (array_key_exists('status', $result) && $result['status'] == 'ok') {
            if (array_key_exists('redirect', $result)) {
                header('Location:' . $result['redirect']);
            } else if (array_key_exists('view', $result) && array_key_exists('data', $result)) {
                return view(
                    $result['view'],
                    [
                        'data' => $result['data']
                    ]
                );
            }
        }else{
            return redirect(env('APP_URL'));
        }
    }
}
