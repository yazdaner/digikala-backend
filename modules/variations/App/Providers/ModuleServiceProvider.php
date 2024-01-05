<?php
namespace Modules\variations\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/variations/database/migrations'));
    }

    public function boot() :void
    {
    }

}

