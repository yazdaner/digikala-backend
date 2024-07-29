<?php

namespace Modules\variations\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Modules\variations\App\Models\Variation;
use Modules\variations\App\Http\Requests\GeneralUpdateVariationRequest;

class GeneralUpdateVariationsController extends Controller
{
    public function __invoke(GeneralUpdateVariationRequest $request)
    {
        $category_id = $request->post('category_id');
        $brand_id = $request->post('brand_id');
        $column = $request->post('column', 'price2');
        $amount = $request->post('amount');
        $percent = $request->post('percent');
        $variations = Variation::query();
        if (intval($brand_id) > 0) {
            $variations->whereHas('product', function (Builder $builder) use ($brand_id) {
                $builder->where('brand_id', $brand_id);
            });
        }
        if (intval($category_id) > 0) {
            define('productCategories_local_key', 'product_id');
            $variations->whereHas('productCategories', function (Builder $builder) use ($category_id) {
                $builder->where('category_id', $category_id);
            });
        }

        if (!empty($amount)) {
            $update = [
                $column => DB::raw($column . '+' . $amount)
            ];
            if ($column == 'price2') {
                $update['price1'] = DB::raw('price1 +' . $amount);
            }
            $variations->update($update);
        } elseif (!empty($percent)) {
            $update = [
                $column => DB::raw($column . '+(CONVERT( (' . $column . '*' . $percent . ')/100 ,int))')
            ];

            if ($column == 'price2') {
                $update['price1'] = DB::raw('price1+(CONVERT( (price1 *' . $percent . ')/100 ,int))');
            }

            $variations->update($update);
        }
        return ['status' => 'ok'];
    }
}
