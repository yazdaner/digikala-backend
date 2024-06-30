<?php

namespace Modules\statistics\App\Events;

use Modules\statistics\App\Jobs\AddCategoryBrandStatisticsJob;

class AddCategoryBrandStatistics
{
    public function handle($order)
    {
        AddCategoryBrandStatisticsJob::dispatch($order);
    }
}
