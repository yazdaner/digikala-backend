<?php

namespace Modules\normaldelivery\export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class GeneralSetting implements FromArray, WithHeadings, WithTitle
{
    protected int $cityId;

    public function __construct($city_id)
    {
        $this->cityId = $city_id;
    }

    public function array(): array
    {
        return [
            [
                runEvent(
                    'setting:value',
                    'min_buy_free_normal_shipping_' . $this->cityId,
                    true
                ),
                runEvent(
                    'setting:value',
                    'normal_delivery_time_' . $this->cityId,
                    true
                ),
                runEvent(
                    'setting:value',
                    'normal_shopping_cost_' . $this->cityId,
                    true
                )
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'min_buy',
            'delivery_time',
            'shapping_cost'
        ];
    }

    public function title(): string
    {
        return 'general-setting';
    }
}
