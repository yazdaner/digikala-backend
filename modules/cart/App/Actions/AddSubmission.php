<?php

namespace Modules\cart\App\Actions;

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
        foreach ($products as $product) {
            # code...
        }
    }
}
