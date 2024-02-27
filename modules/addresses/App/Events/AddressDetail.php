<?php

namespace Modules\addresses\App\Events;

use Modules\addresses\App\Models\Address;

class AddressDetail
{
    public function handle($where)
    {
        return Address::where($where)->first();
    }
}
