<?php

namespace Modules\normaldelivery\import;

class ShippingIntervals
{
    protected int $city_id;

    public function __construct($city_id)
    {
        $this->city_id = $city_id;
    }
}
