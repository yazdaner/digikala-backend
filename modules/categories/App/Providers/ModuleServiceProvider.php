<?php
namespace Modules\categories\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/categories/database/migrations'));
    }

    public function boot() :void
    {
       require_once base_path('modules/categories/helpers.php');
    }

}

