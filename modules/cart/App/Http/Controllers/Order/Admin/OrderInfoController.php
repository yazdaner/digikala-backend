<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;

class OrderInfoController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $user = $request->user();
        $order = Order::withoutTrashed()
            ->with([
                'submissions.items.product',
                'submissions.items.variation',
                'address'
            ]);
        if(config('shop-info.multi-seller') == 'true'){
            $order = $order->with('submissions.items.seller',function($query){
                return $query->select(['id','brandName']);
            });
        }
        if($user->role == 'user' && $user->role_id == 0){
            $order = $order->where('user_id',$user->id);
        }
        $order = $order->findOrFail($id);
        $order->user_info = runEvent('user:info',$order->user_id,true);
        return runEvent('completing_order_info',$order,true);
        
    }
    
}
