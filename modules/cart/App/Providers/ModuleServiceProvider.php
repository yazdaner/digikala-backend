<?php
namespace Modules\cart\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/cart/database/migrations'));
    }

    public function boot() :void
    {
    }

}

