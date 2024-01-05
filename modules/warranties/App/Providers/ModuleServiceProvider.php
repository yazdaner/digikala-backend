<?php
namespace Modules\warranties\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/warranties/database/migrations'));
    }

    public function boot() :void
    {
    }

}

