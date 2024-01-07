<?php
namespace Modules\favourites\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/favourites/database/migrations'));
    }

    public function boot() :void
    {
    }

}

