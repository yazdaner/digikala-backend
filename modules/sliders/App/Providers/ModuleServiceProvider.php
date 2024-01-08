<?php
namespace Modules\sliders\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/sliders/database/migrations'));
    }

    public function boot() :void
    {
    }

}

