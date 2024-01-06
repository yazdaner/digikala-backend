<?php
namespace Modules\galleries\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/galleries/database/migrations'));
    }

    public function boot() :void
    {
    }

}

