<?php

namespace Modules\cart\App\Http\Controllers\Order\Admin;

use Illuminate\Http\Request;
use Modules\cart\App\Models\Order;
use App\Http\Controllers\Controller;

class LabelInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        $result = [];
        $arr = explode(',',$request->get('id'));
        foreach($arr as $id){
            if($id){
                $order = Order::select(['address_id'])
                    ->where('id',$id)
                    ->with('address')
                    ->first();
                if($order){
                    $result[] = $order->address;
                }
            }
        }
        return $result;
    }
}
