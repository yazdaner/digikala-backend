<?php

namespace Modules\normaldelivery\import;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\normaldelivery\App\Models\IntervalsNormalPosting;

class ShippingIntervals implements ToArray, WithHeadingRow
{
    protected int $cityId;

    public function __construct($city_id)
    {
        $this->cityId = $city_id;
    }

    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $keys = array_keys($row);
            $values = array_values($row);
            $date = $values[0];
            foreach ($values as $key => $value) {
                if($key > 0){
                    IntervalsNormalPosting::create([
                        'city_id' => $this->cityId,
                        'date' => $date,
                        'time' => str_replace('_','-',$keys[$key]),
                        'capacity' => $value,
                    ]);
                }
            }
        }
    }
}
