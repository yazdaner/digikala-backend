<?php
namespace Modules\normaldelivery\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/normaldelivery/database/migrations'));
    }

    public function boot() :void
    {
    }

}

