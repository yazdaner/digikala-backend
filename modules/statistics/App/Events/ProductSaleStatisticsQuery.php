<?php

namespace Modules\statistics\App\Events;

use Modules\statistics\App\Models\ProductsSaleStatistic;

class ProductSaleStatisticsQuery
{
    public function handle($function)
    {
        $query = ProductsSaleStatistic::query();
        return $function($query);
    }
}
