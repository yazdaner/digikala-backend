<?php

namespace Modules\setting\App\Events;

use Modules\setting\App\Models\Setting;

class UpdateOrCreate
{
    public function handle($array)
    {
        foreach ($array as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ], [
                'value' => $value,
            ]);
        }
    }
}
