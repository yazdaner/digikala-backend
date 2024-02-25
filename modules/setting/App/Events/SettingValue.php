<?php

namespace Modules\setting\App\Events;

use Modules\setting\App\Models\Setting;

class SettingValue
{
    public function handle($key)
    {
        $row = Setting::where('key',$key)->first();
        if($row) {
            return $row->value;
        }else{
            return '';
        }
    }
}
