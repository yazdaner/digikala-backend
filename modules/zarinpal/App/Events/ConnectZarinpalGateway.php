<?php

namespace Modules\zarinpal\App\Events;

use Modules\zarinpal\Zarinpal;

class ConnectZarinpalGateway
{
    public function handle($payment)
    {
        $zarinpal = new Zarinpal();
        $code1 = $zarinpal->pay($payment->price, $payment->callbackUrl);
        if ($code1) {
            $payment->code1 = $code1;
            $payment->update();
            $redirect = 'https://www.zarinpal.com/pg/StartPay/' . $code1;
            return ['status' => 'ok', 'redirect' => $redirect];
        }else{
            return ['status' => 'error'];
        }
    }
}
