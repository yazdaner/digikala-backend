<?php
namespace Modules\cart\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\cart\App\Events\ReturnProductsByOrderId;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/cart/database/migrations'));
        require_once base_path('modules/cart/helpers.php');
        addEvent('order:products',ReturnProductsByOrderId::class);
    }

    public function boot() :void
    {
    }

}

