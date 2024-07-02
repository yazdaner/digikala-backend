<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use App\Http\Controllers\Controller;
use Modules\cart\App\Models\Submission;

class SubmissionsStatisticsController extends Controller
{
    public function __invoke()
    {
        $statistics = [];
        $statuses = config('app.order-statuses');
        foreach ($statuses as $status) {
            $statistics[$status['value']] = Submission::where('send_status', $status['value'])
                ->count();
        }
        return $statistics;
    }
}
