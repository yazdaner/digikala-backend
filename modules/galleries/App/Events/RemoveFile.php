<?php

namespace Modules\galleries\App\Events;

class RemoveFile
{
    public function handle($path)
    {
        if(file_exists($path)){
            unlink($path);
        }
    }
}
