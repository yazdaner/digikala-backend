<?php
namespace Modules\core\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
       require_once base_path('modules/core/helpers.php');
    }

    public function boot() :void
    {
        addModulesProviders();
    }

}

