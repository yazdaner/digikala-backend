<?php

namespace Modules\variations\App\Events;

use Modules\variations\App\Models\Variation;

class AddProductVariation
{
    public function handle($data)
    {
        $request = $data['request'];
        $product_id = $data['product_id'];
        $variation = new Variation($request->all());
        $variation->product_id = $product_id;
        $variation->status = $request->get('status') == 'true' ? 1 : 0;
        $variation = runEvent('variation:creating',$variation,true);
        $variation->saveOrFail();
    }
}
