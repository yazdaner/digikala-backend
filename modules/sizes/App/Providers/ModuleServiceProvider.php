<?php
namespace Modules\sizes\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/sizes/database/migrations'));
    }

    public function boot() :void
    {
    }

}

