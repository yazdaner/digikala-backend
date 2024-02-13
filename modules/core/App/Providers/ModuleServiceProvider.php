<?php

namespace Modules\core\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        require_once base_path('modules/core/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/core/database/migrations'));
        // 'auth','isAdmin'
        if (!defined('AdminMiddleware')) {
            define('AdminMiddleware', []);
        }
        $this->loadViewsFrom(base_path('modules/core/resources/view'),'core');
    }

    public function boot(): void
    {
        addModulesProviders();
    }
}
