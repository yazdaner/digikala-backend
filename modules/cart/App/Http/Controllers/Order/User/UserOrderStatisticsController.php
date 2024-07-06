<?php

namespace Modules\cart\App\Http\Controllers\Order\User;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class UserOrderStatisticsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user_id = $request->user()->id;
        $progress_statuses = config('app.order:progress_statuses');
        $orders = Order::query()->where('user_id', $user_id);
        
        $current = $orders
            ->whereHas('submissions', function (Builder $builder) use ($progress_statuses) {
                $builder->whereIn('status', $progress_statuses);
            })->count();

        $delivered = $orders
            ->where('status', 25)->count();

        $canceled = $orders
            ->where('status', -1)->count();

        return [
            'current' => $current,
            'delivered' => $delivered,
            'canceled' => $canceled,
            'returned' => 0,
        ];

    }
}
