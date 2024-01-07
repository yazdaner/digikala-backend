<?php
namespace Modules\holidays\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/holidays/database/migrations'));
    }

    public function boot() :void
    {
    }

}

