<?php

namespace Modules\normaldelivery\import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GeneralSetting implements ToModel,WithHeadingRow
{
    protected int $cityId;

    public function __construct($city_id)
    {
        $this->cityId = $city_id;
    }

    public function model(array $row)
    {
        runEvent('setting:update-create', [
            'min_buy_free_normal_shipping_' . $this->cityId
            => $row['min_buy'],
            'normal_delivery_time_' . $this->cityId
            => $row['delivery_time'],
            'normal_shopping_cost_' . $this->cityId
            => $row['shopping_cost'],
        ]);
    }
}
