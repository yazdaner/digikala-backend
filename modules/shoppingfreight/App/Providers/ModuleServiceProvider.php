<?php
namespace Modules\shoppingfreight\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/shoppingfreight/database/migrations'));
    }

    public function boot() :void
    {
    }

}

