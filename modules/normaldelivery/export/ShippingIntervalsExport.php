<?php

namespace Modules\normaldelivery\export;

use Modules\normaldelivery\export\GeneralSetting;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\normaldelivery\export\ShippingIntervals;

class ShippingIntervalsExport implements WithMultipleSheets
{
    protected int $city_id;

    public function __construct($city_id)
    {
        $this->city_id = $city_id;
    }

    public function sheets(): array
    {
        return [
            new GeneralSetting($this->city_id),
            new ShippingIntervals($this->city_id),
        ];
    }
}
