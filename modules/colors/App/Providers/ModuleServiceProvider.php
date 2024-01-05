<?php
namespace Modules\colors\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/colors/database/migrations'));
    }

    public function boot() :void
    {
    }

}

