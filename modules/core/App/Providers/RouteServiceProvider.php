<?php

namespace Modules\core\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modules = config('app.modules');
        foreach ($modules as $module) {
            $apiRoutes = base_path('modules/' . $module . '/Routes/api.php');
            $webRoutes = base_path('modules/' . $module . '/Routes/web.php');
            $namespace = 'Modules\\' . $module . '\\App\\Http\\Controllers';
            if (file_exists($apiRoutes)) {
                Route::middleware('api')
                    ->prefix('api')
                    ->namespace($namespace)
                    ->group($apiRoutes);
            }
            if (file_exists($webRoutes)) {
                Route::middleware('web')
                    ->namespace($namespace)
                    ->group($webRoutes);
            }
        }
    }
}
