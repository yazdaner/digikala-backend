<?php
namespace Modules\discounts\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

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
