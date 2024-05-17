<?php

namespace Modules\zarinpal\App\Events;

use Modules\zarinpal\Zarinpal;

class VerifyPayment
{
    public function handle($request)
    {
        if ($request->has('Authority')) {
            $payment = runEvent('online-payment:find', [
                'code1' => $request->get('Authority')
            ], true);
            if (is_object($payment)) {
                $zarinpal = new Zarinpal();
                $code2 = $zarinpal->verify($payment->price);
                if($code2){
                    $payment->code2 = $code2;
                    $payment->status = 'ok';
                    $payment->update();
                    return $payment;
                }
            }
        }
    }
}
