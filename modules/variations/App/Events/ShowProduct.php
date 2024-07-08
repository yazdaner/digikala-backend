<?php

namespace Modules\variations\App\Events;

class ShowProduct
{
    public function handle($product)
    {
        if ($product->variations != null && sizeof($product->variations) > 0) {
            $firstVariations = $product->variations[0];
            if ($firstVariations->selected_buy_box == false) {
                $firstVariations->selected_buy_box = true;
                $firstVariations->update();
            }
        }
    }
}
