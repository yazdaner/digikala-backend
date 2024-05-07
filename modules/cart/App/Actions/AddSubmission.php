<?php

namespace Modules\cart\App\Actions;

use Illuminate\Support\Js;
use Modules\cart\App\Models\OrderProduct;
use Modules\core\Lib\Jdf;
use Modules\cart\App\Models\Submission;

class AddSubmission
{
    public function __invoke($order, $submissionInfo, $user)
    {
        $data = [
            'user_id' => $user->id,
            'order_id' => $order->id,
            'shipping_cost' => intval($submissionInfo['shipping_cost']) > 0 ? $submissionInfo['shipping_cost'] : 0,
            'send_status' => 0,
            'send_type' => $submissionInfo['name'],
            'sender' => array_key_exists('sender', $submissionInfo) ? $submissionInfo['sender'] : 0,
        ];
        $data = runEvent('submission:saving', $data, true);
        $submission = Submission::create($data);
        $this->addProducts($submissionInfo['products'], $submission);
    }

    protected function addProducts($products, $submission)
    {
        $shipping_time = 0;
        foreach ($products as $product) {
            $preparation_timestamp = strtotime('+'.($product->variation->preparation_time + 1).'days');
            $timestamp = Jdf::jmktime(
                intval(config('order.last_hour')),
                0,
                0,
                Jdf::jdate('n',$preparation_timestamp),
                Jdf::jdate('j',$preparation_timestamp),
                Jdf::jdate('Y',$preparation_timestamp)
            );
            $data = [
                'submission_id' => $submission->id,
                'order_id' => $submission->order_id,
                'variation_id' => $product->variation->id,
                'product_id' => $product->id,
                'price1' => $product->variation->price1,
                'price2' => $product->variation->price2,
                'count' => $product->count,
                'preparation_time' => $timestamp
            ];

            $data = runEvent('submission-product:saving',$data,true);
            OrderProduct::create($data);
            if($timestamp > $shipping_time){
                $shipping_time = $timestamp;
            }
        }
        if($shipping_time > 0){
            $submission->shipping_time = $shipping_time;
            $submission->update();
        }
    }
}
