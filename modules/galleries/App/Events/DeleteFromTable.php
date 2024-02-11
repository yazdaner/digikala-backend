<?php

namespace Modules\galleries\App\Events;

use Modules\galleries\App\Models\Gallery;

class DeleteFromTable
{
    public function handle($id)
    {
        Gallery::where('id',$id)->delete();
    }
}
