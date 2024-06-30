<?php

namespace Modules\statistics\App\Events;

use Modules\statistics\App\Jobs\AddProductsSaleStatisticsJob;

class AddProductsSaleStatistics
{
    public function handle($order)
    {
        AddProductsSaleStatisticsJob::dispatch($order);
    }
}
