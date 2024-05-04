<?php
namespace Modules\cart\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/cart/database/migrations'));
        require_once base_path('modules/cart/helpers.php');
    }

    public function boot() :void
    {
    }

}

