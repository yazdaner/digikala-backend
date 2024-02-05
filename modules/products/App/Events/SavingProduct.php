<?php

namespace Modules\products\App\Events;

use Modules\products\App\Models\ProductsDetail;

class SavingProduct
{
    protected array $options =
    [
        'general_product_id',
        'height',
        'length',
        'origin',
        'strengths',
        'weaknesses',
        'weight',
        'width',
        'product_dimensions',
        'barcode',
        'barcode_type',
    ];
    public function handle($product)
    {
        $request = request();
        ProductsDetail::where('product_id', $product->id)->delete();
        foreach ($this->options as $option) {
            if ($request->post($option) != null && trim($request->post($option)) != '') {
                ProductsDetail::create([
                    'product_id' => $product->id,
                    'name' => $option,
                    'value' => $request->post($option),
                ]);
            }
        }
    }
}
