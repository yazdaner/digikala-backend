<?php

namespace Modules\cart\App\Http\Controllers\Order\User;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class UserOrdersController extends Controller
{
    public function __invoke(Request $request)
    {
        $user_id = $request->user()->id;
        $orders = Order::query();
        $orders->where('user_id', $user_id);
        $status = $request->get('status');
        $progress_statuses = config('app.order:progress_statuses');
        switch ($status) {
            case 'delivered':
                $orders->with('items.product')
                    ->where('status', 25);
                break;
            case 'canceled':
                $orders->with('items.product')
                    ->where('status', -1);
                break;
            default:
                $orders->with('submissions.items.product')
                    ->whereHas('submissions', function (Builder $builder) use ($progress_statuses) {
                        $builder->whereIn('status', $progress_statuses);
                    });
        }
        return $orders->paginate(env('PAGINATE'));
    }
}
