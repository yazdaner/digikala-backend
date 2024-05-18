<?php

use Modules\setting\App\Models\Setting;

function settings($items)
{
    $setting = [];
    foreach ($items as $item) {
        $row = Setting::where('key',$item)->first();
        $setting[$item] = '';
        if($row){
            $setting[$item] = $row->value;
        }
    }
    return $setting;
}
