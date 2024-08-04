<?php

namespace Modules\addresses\App\Events;

use Modules\addresses\App\Jobs\CreateStaticMap as CreateStaticMapJob;

class CreateStaticMap
{
    public function handle($address_id)
    {
        CreateStaticMapJob::dispatch($address_id);
    }
}
