<?php

namespace Modules\variations\App\Events;

use Modules\variations\App\Models\Variation;

class UpdateProductVariation
{
    public function handle($data)
    {
        $request = $data['request'];
        $variation_id = $data['variation_id'];

        $variation = Variation::findOrFail($variation_id);
        $data = $request->all();
        $arr = [
            'param1_type',
            'param1_id',
            'param2_type',
            'param2_id',
        ];
        foreach ($arr as $value) {
            if (array_key_exists($value, $data)) {
                unset($data[$value]);
            }
        }
        if(isset($data['status'])){
            $data['status'] = $data['status'] == 'true' ? 1 : 0;
        }
        $variation->update($data);
        return ['status' => 'ok'];
    }
}
