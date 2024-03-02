<?php

namespace Modules\normaldelivery\App\Events;

class _TimeIntervals
{
    protected int $delivery_period;
    protected int $delivery_period_timestamp;

    protected function getTimeIntervals($cityId, $sender)
    {
        $this->setDeliveryPeriod();
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

        }
    }
}
