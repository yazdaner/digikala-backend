<?php

namespace Modules\onlinepayment\Events;

use Modules\onlinepayment\App\Models\Payment;

class RequestPayment
{
    public function handle($data)
    {
        $gateway = runEvent('setting:value', 'gateway', true);
        if ($gateway) {
            $data['gateway'] = $gateway;
            $data['status'] = 'suspended';
            return Payment::create($data);
        }
    }
}
