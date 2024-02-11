<?php

namespace Modules\galleries\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\galleries\App\Events\RemoveFile;
use Modules\galleries\App\Events\UploadFiles;
use Modules\galleries\App\Events\GalleryFiles;
use Modules\galleries\App\Events\DeleteFromTable;
use Modules\galleries\App\Events\SelectFileFromTable;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        require_once base_path('modules/galleries/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/galleries/database/migrations'));
        addEvent('gallery:upload', UploadFiles::class);
        addEvent('gallery:find', SelectFileFromTable::class);
        addEvent('gallery:delete', DeleteFromTable::class);
        addEvent('gallery:remove-file', RemoveFile::class);
        addEvent('gallery:files', GalleryFiles::class);
    }

    public function boot(): void
    {
    }
}
