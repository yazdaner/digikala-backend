<?php
namespace Modules\statistics\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\statistics\App\Events\AddGeneralSaleStatistics;
use Modules\statistics\App\Events\AddProductsSaleStatistics;
use Modules\statistics\App\Events\AddCategoryBrandStatistics;
use Modules\statistics\App\Events\AddProvincesSaleStatistics;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/statistics/database/migrations'));
        addEvent('order:verified',AddProvincesSaleStatistics::class);
        addEvent('order:verified',AddGeneralSaleStatistics::class);
        addEvent('order:verified',AddProductsSaleStatistics::class);
        addEvent('order:verified',AddCategoryBrandStatistics::class);
    }

    public function boot() :void
    {
    }

}

