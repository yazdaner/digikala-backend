<?php
namespace Modules\users\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\users\App\Http\Middleware\IsAdmin;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->app->router->aliasMiddleware('isAdmin',IsAdmin::class);
        $this->loadMigrationsFrom(base_path('modules/users/database/migrations'));
        require_once base_path('modules/users/helpers.php');
    }

    public function boot() :void
    {
    }

}

