<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\variations\App\Models\Variation;

class UniqueReview implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $request = request();
        $params = $request->route()->parameters();
        $result = true;
        if (array_key_exists('product_id', $params)) {
            $where = ['product_id' => $params['product_id']];
            if ($request->has('param1_id') && !empty($request->get('param1_id'))) {
                $where['param1_id'] = $request->get('param1_id');
                $where['param1_type'] = $request->get('param1_type');
            }
            if ($request->has('param2_id') && !empty($request->get('param2_id'))) {
                $where['param2_id'] = $request->get('param2_id');
                $where['param2_type'] = $request->get('param2_type');
            }
            $query = Variation::query();
            $query->where($where);
            // $query = runEvent('variation:unique-review', $query, true);
            if ($query->first()) {
                $result = false;
                if (array_key_exists('id', $params) && $params['id'] == $query->id) {
                    $result = true;
                }
            }
        }
        if (!$result) {
            $fail('تنوع قیمت قبلا ثبت شده');
        }
    }
}
