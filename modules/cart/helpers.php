<?php

function getSenders($products)
{
    $senders = [];
    foreach ($products as $product) {
        if($product->variation != null){
            if($product->variation->sender == 'self'){
                $senders[0] = 0;
            }else{
                $senders[$product->variation->seller_id] = $product->variation->seller_id;
            }
        }
    }
    return array_values($senders);
}
