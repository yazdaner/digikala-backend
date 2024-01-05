<?php
namespace Modules\products\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/products/database/migrations'));
    }

    public function boot() :void
    {
    }

}

