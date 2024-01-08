<?php
namespace Modules\shoppingfreightdelivery\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/shoppingfreightdelivery/database/migrations'));
    }

    public function boot() :void
    {
    }

}

