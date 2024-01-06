<?php
namespace Modules\addresses\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/addresses/database/migrations'));
    }

    public function boot() :void
    {
    }

}

