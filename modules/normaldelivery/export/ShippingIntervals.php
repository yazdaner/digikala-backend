<?php

namespace Modules\normaldelivery\export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Modules\normaldelivery\App\Models\IntervalsNormalPosting;

class ShippingIntervals implements FromArray, WithHeadings, WithTitle
{
    protected int $cityId;
    protected array $intervals;

    public function __construct($city_id)
    {
        $this->cityId = $city_id;
        $this->addIntervals();
    }
    public function array(): array
    {
        $array = [];
        $dates = [];
        foreach ($this->intervals as $interval) {
            $dates[$interval['date']][] = $interval['capacity'];
        }
        foreach ($dates as $date => $capacities) {
            $row = [$date];
            for ($i=0; $i < sizeof($capacities); $i++) {
                $row[] = $capacities[$i];
            }
            $array = [$row];
        }
        return $array;
    }

    public function headings(): array
    {
        $headings = ['#'];
        foreach ($this->intervals as $interval) {
            $headings[$interval['time']] = $interval['time'];
        }
        return $headings;
    }

    public function title(): string
    {
        return 'intervals-time';
    }

    protected function addIntervals()
    {
        $this->intervals = IntervalsNormalPosting::where(
            'city_id',
            $this->cityId
        )->get()->toArray();
    }
}
