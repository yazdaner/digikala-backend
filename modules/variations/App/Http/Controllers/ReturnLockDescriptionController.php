<?php

namespace Modules\variations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\variations\App\Models\SalesLock;

class ReturnLockDescriptionController extends Controller
{
    public function __invoke($product_id)
    {
        $product = runEvent('product:query', function ($query) use ($product_id) {
            return $query->findOrFail($product_id);
        }, true);
        $categories = runEvent('product:categories', $product_id, true);

        $wheres = [
            ['category_id' => $categories, 'brand_id' => $product->brand_id],
            ['category_id' => $categories],
            ['category_id' => 0, 'brand_id' => $product->brand_id],
            ['category_id' => 0, 'brand_id' => 0],
        ];
        $lock = null;
        foreach ($wheres as $where) {
            if ($lock == null) {
                $query = SalesLock::query();
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, $value);
                    }
                }
                $lock = $query->first();
            }
        }
        return $lock;
    }
}
