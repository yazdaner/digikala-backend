<?php

namespace Modules\variations\App\Actions;

use Illuminate\Database\Eloquent\Builder;
use Modules\variations\App\Models\Variation;

class VariationUnlock
{
    public function __invoke($data)
    {
        $variations = Variation::query();
        if ($data->category_id > 0) {
            $category_id = $data->category_id;
            define('productCategories_local_key', 'product_id');
            $variations->whereHas('productCategories', function (Builder $builder) use ($category_id) {
                return $builder->where('category_id', $category_id);
            });
        }
        if ($data->brand_id > 0) {
            $brand_id = $data->brand_id;
            $variations->whereHas('product', function (Builder $builder) use ($brand_id) {
                return $builder->where('brand_id', $brand_id);
            });
        }
        $variations->where(['status' => 2])->update(['status' => 1]);
    }
}
