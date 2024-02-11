<?php

namespace Modules\galleries\App\Events;

use Modules\galleries\App\Models\Gallery;

class SelectFileFromTable
{
    public function handle($data)
    {
        Gallery::where([
            'tableable_id' => $data['id'],
            'tableable_type' => $data['tableable_type'],
        ])->orderBy('position', 'ASC')
            ->get();
    }
}
