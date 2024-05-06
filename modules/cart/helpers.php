<?php

function getSenders($products)
{
    $senders = [];
    foreach ($products as $product) {
        if ($product->variation != null) {
            if ($product->variation->sender == 'self') {
                $senders[0] = 0;
            } else {
                $senders[$product->variation->seller_id] = $product->variation->seller_id;
            }
        }
    }
    return array_values($senders);
}

function getSubmissions($products)
{
    $submissions = [];
    $shippingMethods = config('app.shipping-methods');
    usort($shippingMethods, function ($item1, $item2) {
        $p1 = array_key_exists('priority', $item1) ? $item1['priority'] : 10;
        $p2 = array_key_exists('priority', $item2) ? $item2['priority'] : 10;
        return ($p1 - $p2);
    });
    $senders = getSenders($products);
    foreach ($senders as $sender) {
        foreach ($shippingMethods as $method) {
            $submission = runEvent($method['event'], [
                'products' => $products,
                'sender' => $sender
            ], true);
            if (is_array($submission) && array_key_exists('selected_keys', $submission) && sizeof($submission['products']) > 0) {
                foreach ($submission['selected_keys'] as $key) {
                    unset($products[$key]);
                }
                $submissions[] = $submission;
            }
        }
    }
    return $submissions;
}
