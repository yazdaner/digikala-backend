<?php

namespace Modules\cart\App\Actions;

use Modules\cart\App\Models\Order;

class AddOrder
{
    public function __invoke($request,$submissions,$user)
    {
       return Order::first();
    }
}
