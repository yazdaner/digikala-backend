<?php
namespace Modules\supermarketdelivery\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/supermarketdelivery/database/migrations'));
    }

    public function boot() :void
    {
    }

}

