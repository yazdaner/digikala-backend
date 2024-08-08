<?php

namespace Modules\statistics\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\statistics\App\Models\CategoryBrandStatistics;

class MostPopularBrandsController extends Controller
{
    public function __invoke()
    {
        $query = CategoryBrandStatistics::query();
        $query->with('brand');
        return $query->select([
            'brand_id',
            DB::raw('sum(count) as total_sale')
        ])
        ->limit(env('PAGINATE'))
        ->orderBy('total_sale','DESC')
        ->groupBy('brand_id')
        ->get();
    }
}


