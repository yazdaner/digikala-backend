<?php

namespace Modules\normaldelivery\import;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\normaldelivery\App\Models\IntervalsNormalPosting;

class ShippingIntervalsImport implements WithMultipleSheets
{
    protected int $city_id;

    public function __construct($city_id)
    {
        $this->city_id = $city_id;
        IntervalsNormalPosting::where('city_id', $city_id)->delete();
    }

    public function sheets(): array
    {
        return [
            new GeneralSetting($this->city_id),
            new ShippingIntervals($this->city_id),
        ];
    }
}
