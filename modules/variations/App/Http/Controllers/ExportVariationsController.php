<?php

namespace Modules\variations\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Modules\variations\App\Models\Variation;
use Modules\variations\App\Exports\VariationExport;

class ExportVariationsController extends Controller
{
    public function __invoke(Request $request)
    {
        $category_id = $request->post('category_id');
        $brand_id = $request->post('brand_id');
        $variations = Variation::query();
        $variations->with(['param1', 'param2', 'product']);
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
        $result = $variations->paginate(250);
        if ($result->count() > 0) {
            return Excel::download(new VariationExport($result), 'variations.xlsx');
        } else {
            return null;
        }
    }
}
