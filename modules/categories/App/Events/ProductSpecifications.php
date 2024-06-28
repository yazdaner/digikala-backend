<?php

namespace Modules\categories\App\Events;

use Illuminate\Support\Facades\DB;

class ProductSpecifications
{
    public function handle($id)
    {
        $product_specifications = DB::table('products__specifications')
        ->where('product_id',$id)
        ->pluck('value','characteristic_id')
        ->toArray();
        $characteristicId = array_keys($product_specifications);
        $specifications = DB::table('specifications')
            ->whereIn('id',$characteristicId)
            ->orderBy('position','ASC')
            ->get();
        $result = [];
        foreach ($specifications as $specification) {
            if(array_key_exists($specification->id,$product_specifications)){
                $result[$specification->id]=[
                    'key' => $specification->name,
                    'value' => $product_specifications[$specification->id],
                    'position' => $specification->position,
                ];
            }
        }
        return $result;
    }
}
