<?php
namespace Modules\discounts\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/discounts/database/migrations'));
    }

    public function boot() :void
    {
       //
    }
}
