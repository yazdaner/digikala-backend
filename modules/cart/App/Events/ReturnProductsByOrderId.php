<?php

namespace Modules\cart\App\Events;

use Modules\cart\App\Models\OrderProduct;
use Modules\cart\App\Models\Submission;

class ReturnProductsByOrderId
{
    public function handle($order_id)
    {
        $submissions = Submission::where('order_id', $order_id)
            ->pluck('id')->toArray();
        return OrderProduct::whereIn('submission_id', $submissions)
            ->get();
    }
}
