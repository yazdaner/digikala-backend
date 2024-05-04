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
        if (sizeof($days) > 0) {
            return $this->createIntervalsFromDefindDays($days);
        } else {
            return $this->createDaynamicIntervals($cityId, $sender);
        }
    }

    protected function setDeliveryPeriod($cityId, $sender)
    {
        $senderKey = $sender == 0 ? '' : "sender_{$sender}_";
        $period = 1 + $this->preparation_time;

        $normal_delivery_time = runEvent(
            'setting:value',
            $senderKey . "normal_delivery_time_{$cityId}",
            true
        );

        if (!$normal_delivery_time) {
            $normal_delivery_time = runEvent(
                'setting:value',
                $senderKey . "normal_delivery_time",
                true
            );
        }

        if (intval($normal_delivery_time) > 0) {
            $period += intval($normal_delivery_time);
        }
        $this->delivery_period = $period;
    }

    protected function recordedDay($cityId, $sender)
    {
        $days = [];
        for ($i = $this->delivery_period; $i < ($this->delivery_period + 7); $i++) {
            $timestamp = strtotime("+ {$i} days");
            $days[] = Jdf::jdate('Y/n/j', $timestamp);
        }
        return IntervalsNormalPosting::whereIn('date', $days)
            ->where([
                'city_id' => $cityId,
                'sender' => $sender,
            ])
            ->orderBy('id', 'ASC')
            ->get()
            ->unique('date')
            ->take(5);
    }

    protected function createDaynamicIntervals($cityId, $sender)
    {
        $daynamic = IntervalsNormalPosting::where([
            'date' => '*',
            'city_id' => $cityId,
            'sender' => $sender,
        ])->first();
        $list = [];
        $weekOfDayArr = [];
        if ($daynamic) {
            $period = $this->delivery_period;
            $dateArr = [];
            for ($i = $period; $i <= ($period + 10); $i++) {
                $timestamp = strtotime("+ {$i} days");
                $l = Jdf::jdate('l', $timestamp);
                if ($l != 'جمعه') {
                    $date = Jdf::jdate('Y/n/j', $timestamp);
                    $dateArr[] = $date;
                    $weekOfDayArr[$date] = $l;
                }
            }
            $holidays = runEvent('get-holidays',$this->delivery_period_timestamp,true);
            if(is_array($holidays)){
                $dateArr = array_diff($dateArr,$holidays);
            }
        }
        return $list;
    }

    protected function createIntervalsFromDefindDays($days)
    {
    }
}
