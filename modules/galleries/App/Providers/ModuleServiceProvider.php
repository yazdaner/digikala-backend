<?php

namespace Modules\galleries\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\galleries\App\Models\Gallery;
use Modules\galleries\App\Events\RemoveFile;
use Modules\galleries\App\Events\UploadFiles;
use Modules\galleries\App\Events\GalleryFiles;
use Modules\galleries\App\Events\DeleteFromTable;
use Modules\galleries\App\Events\ProductPageQuery;
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
        addEvent('shop:product-page', ProductPageQuery::class);
    }

    public function boot(): void
    {
        Builder::macro('gallery', function () {
            $query = $this->getModel()->hasMany(
                Gallery::class,
                'tableable_id',
                'id'
            );
            if(defined('gallery_tableable_type')){
                $query->where('tableable_type',gallery_tableable_type);
            }
            return $query;
        });
        
    }
}
