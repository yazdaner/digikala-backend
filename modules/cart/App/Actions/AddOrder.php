<?php

namespace Modules\cart\App\Actions;

use Modules\cart\App\Models\Order;

class AddOrder
{
    protected array $submissions;
    public function __invoke($data,$submissions,$user)
    {
        $this->submissions = $submissions;
        $time = time();
        $orderCode = substr($time,0,5).$user->id.substr($time,5,10);
        return Order::create([
            'user_id' => $user->id,
            'total_price' => $this->getTotalPrice(),
            'final_price' => $this->getFinalPrice(),
            'address_id' => $data['address_id'],
            'order_code' => $orderCode,
            'payment_method' => $data['payment_method'],
        ]);
    }

    protected function getTotalPrice() {
        $price = 0;
        foreach ($this->submissions as $submission) {
            $price += $submission['total_price'];
            if($submission['shipping_cost'] > 0){
                $price += $submission['shipping_cost'];
            }
        }
        return $price;
    }

    protected function getFinalPrice() {
        $price = 0;
        foreach ($this->submissions as $submission) {
            $price += $submission['final_price'];
            if($submission['shipping_cost'] > 0){
                $price += $submission['shipping_cost'];
            }
        }
        return $price;
    }
}
