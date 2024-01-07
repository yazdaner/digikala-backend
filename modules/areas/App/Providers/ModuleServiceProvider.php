<?php
namespace Modules\areas\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/areas/database/migrations'));
    }

    public function boot() :void
    {
    }

}

