<?php
namespace Modules\brands\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\brands\App\Models\Brand;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/brands/database/migrations'));
    }

    public function boot() :void
    {
        Builder::macro('brand', function () {
            return $this->getModel()->hasOne(
                Brand::class,
                'id',
                'brand_id'
            )->withDefault(['name' => '']);
        });
    }

}

