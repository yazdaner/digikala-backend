<?php
namespace Modules\sellers\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        require_once base_path('modules/sellers/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/sellers/database/migrations'));
    }

    public function boot() :void
    {
        updateAuthConfigs();
    }

}

