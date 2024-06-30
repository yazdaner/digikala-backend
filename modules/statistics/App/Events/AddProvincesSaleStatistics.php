<?php

namespace Modules\statistics\App\Events;

use Modules\statistics\App\Models\ProvincesSaleStatistic;


class AddProvincesSaleStatistics
{
    public function handle($order)
    {
        $address = runEvent('address-detail', function ($query) use ($order) {
            return $query->where('id',$order->address_id)->first();
        }, true);
        if($address){
            $row = ProvincesSaleStatistic::where([
                'province_id' => $address->province_id
            ])->first();
            if($row){
                $row->increment('order_count');
            }else{
                ProvincesSaleStatistic::create([
                    'province_id' => $address->province_id,
                    'order_count' => 1,
                ]);
            }
        }
    }
}
