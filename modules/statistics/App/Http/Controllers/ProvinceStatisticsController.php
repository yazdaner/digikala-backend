<?php

namespace Modules\statistics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\statistics\App\Models\ProvincesSaleStatistic;

class ProvinceStatisticsController extends Controller
{
    public function __invoke()
    {
        return ProvincesSaleStatistic::pluck('order_count','province_id')
            ->toArray();
    }
}


