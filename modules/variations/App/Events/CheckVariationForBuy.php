<?php

namespace Modules\variations\App\Events;

use Modules\variations\App\Models\Variation;

class CheckVariationForBuy
{
    public function handle($data)
    {
        $variation = Variation::where([
            'id' => $data['id'],
            'status' => 1,
        ])->where('product_count', '>=', $data['count'])
            ->first();

        if ($variation && $variation->max_product_cart >= $data['count']) {
            return $variation;
        } else {
            return null;
        }
    }
}
