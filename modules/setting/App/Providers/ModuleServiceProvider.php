<?php
namespace Modules\setting\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/setting/database/migrations'));
    }

    public function boot() :void
    {
    }

}

