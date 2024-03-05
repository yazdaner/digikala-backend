<?php

namespace Modules\normaldelivery\App\Events;

use Modules\core\Lib\Jdf;
use Modules\normaldelivery\App\Models\IntervalsNormalPosting;

class _TimeIntervals
{
    protected int $delivery_period;
    protected int $delivery_period_timestamp;

    protected function getTimeIntervals($cityId, $sender)
    {
        $this->setDeliveryPeriod($cityId, $sender);
        $this->delivery_period_timestamp = strtotime("+ {$this->delivery_period} days");
        $days = $this->recordedDay($cityId, $sender);
    }

    protected function setDeliveryPeriod($cityId, $sender)
    {
        $senderKey = $sender == 0 ? '' : "sender_{$sender}_";
        $period = 1 + $this->preparation_time;

        $normal_delivery_time = runEvent(
            'setting:value',
            $senderKey . "normal_shipping_time_{$cityId}",
            true
        );

        if (!$normal_delivery_time) {
            $normal_delivery_time = runEvent(
                'setting:value',
                $senderKey . "normal_delivery_time",
                true
            );
        }

        if(intval($normal_delivery_time) > 0){
            $period += intval($normal_delivery_time);
        }
        $this->delivery_period = $period;
    }
    protected function recordedDay($cityId, $sender){
        $jdf = new Jdf;
        $firstDay = $jdf->tr_num(
            $jdf->jdate('Y/n/j',$this->delivery_period_timestamp)
        );
        $row = IntervalsNormalPosting::where([
            'city_id' => $cityId,
            'day' => $firstDay,
            'sender' => $sender
        ])->first();
    }
}
