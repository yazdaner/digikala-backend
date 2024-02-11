<?php

namespace Modules\holidays\App\Events;

use Modules\holidays\App\Models\Holiday;

class Holidays
{
    public function handle($startTime)
    {
        $days = Holiday::query();
        if ($startTime > 0) {
            $days->where('timestamp', '>=', $startTime);
        }
        return $days
            ->orderBy('timestamp', 'ASC')
            ->pluck('date')->toArray();
    }
}
