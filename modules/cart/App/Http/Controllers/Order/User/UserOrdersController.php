<?php

namespace Modules\cart\App\Http\Controllers\Order\User;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;

class UserOrdersController extends Controller
{
    public function __invoke(Request $request)
    {
        $user_id = $request->user()->id;
        $orders = Order::query();
        $orders->where('user_id', $user_id);
        $status = $request->get('status');
        $progress_status = config('app.order:progress_statuses');
        switch ($status) {
            case 'delivered':
                $orders->with('items.product')
                    ->whereIn('status', 25);
                break;
            case 'canceled':
                $orders->with('items.product')
                    ->whereIn('status', $progress_status);
                break;
            default:
                $orders->with('submissions.items.product')
                    ->whereIn('status', $progress_status);
        }
        return $orders->paginate(env('PAGINATE'));
    }
}
