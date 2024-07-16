<?php
namespace Modules\sellers\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\sellers\App\Events\SellerAccess;
use Modules\sellers\App\Http\Middleware\SellerAuthenticate;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        require_once base_path('modules/sellers/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/sellers/database/migrations'));
        $this->app['router']->aliasMiddleware('auth.seller',SellerAuthenticate::class);
        addEvent('access:admin-check',SellerAccess::class);
    }

    public function boot() :void
    {
        updateAuthConfigs();
    }

}

