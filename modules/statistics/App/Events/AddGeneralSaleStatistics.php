<?php

namespace Modules\statistics\App\Events;

use Modules\statistics\App\Jobs\AddGeneralSaleStatisticsJob;

class AddGeneralSaleStatistics
{
    public function handle($order)
    {
        AddGeneralSaleStatisticsJob::dispatch($order);
    }
}
