<?php

namespace Modules\galleries\App\Events;

use Modules\galleries\App\Models\Gallery;

class SelectFileFromTable
{
    public function handle($data)
    {
        return Gallery::where($data)->firstOrFail();
    }
}
