<?php

namespace Modules\categories\App\Events;

use Illuminate\Support\Facades\DB;

class AddProductSpecification
{
    public function handle($product)
    {
        $request = request();
        $product_id = $product->id;
        $values = $request->get('Specification');
        DB::table('products__specifications')->where([
            'product_id' => $product_id
        ])->delete();
        if(is_array($values)){
            foreach ($values as $key => $value) {
                if (!empty($value)) {
                    $e = explode('_', $key);
                    if (sizeof($e) == 2) {
                        if ($value == 'true' && empty($values[$e[0]])) {
                            DB::table('products__specifications')->insert([
                                'product_id' => $product_id,
                                'characteristic_id' => $e[0],
                                'value' => $e[1],
                            ]);
                        }
                    } else {
                        DB::table('products__specifications')->insert([
                            'product_id' => $product_id,
                            'characteristic_id' => $key,
                            'value' => $value,
                        ]);
                    }
                }
            }
        }
    }
}
