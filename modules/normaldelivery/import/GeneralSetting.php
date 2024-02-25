<?php

namespace Modules\normaldelivery\import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GeneralSetting implements ToModel,WithHeadingRow
{
    protected int $city_id;

    public function __construct($city_id)
    {
        $this->city_id = $city_id;
    }

    public function model(array $row){
    }
}
