<?php
namespace Modules\statistics\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/statistics/database/migrations'));
    }

    public function boot() :void
    {
    }

}

