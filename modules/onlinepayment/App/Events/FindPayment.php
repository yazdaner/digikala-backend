<?php

namespace Modules\onlinepayment\App\Events;

use Modules\onlinepayment\App\Models\Payment;

class FindPayment
{
    public function handle($where)
    {
        return Payment::where($where)->first();
    }
}
