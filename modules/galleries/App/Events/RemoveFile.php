<?php

namespace Modules\galleries\App\Events;

class RemoveFile
{
    public function handle($path)
    {
        if(file_exists(fileDirectory($path))){
            unlink(fileDirectory($path));
        }
    }
}
