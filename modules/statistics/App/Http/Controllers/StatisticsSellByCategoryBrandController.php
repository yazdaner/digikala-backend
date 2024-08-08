<?php

namespace Modules\statistics\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\statistics\App\Models\CategoryBrandStatistics;

class StatisticsSellByCategoryBrandController extends Controller
{
    public function __invoke(Request $request)
    {
        $groupBy = $request->get('groupBy');
        $query = CategoryBrandStatistics::query();
        $query->with($groupBy == 'brand_id' ? 'brand' : 'category');
        return $query->select([
            $groupBy,
            DB::raw('sum(count) as total_sale')
        ])
        ->limit(env('PAGINATE'))
        ->orderBy('total_sale','DESC')
        ->groupBy($groupBy)
        ->get();
    }
}


