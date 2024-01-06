<?php
namespace Modules\promotions\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/promotions/database/migrations'));
    }

    public function boot() :void
    {
    }

}

