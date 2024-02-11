<?php
namespace Modules\holidays\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\holidays\App\Events\Holidays;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/holidays/database/migrations'));
        addEvent('get-holidays',Holidays::class);
    }

    public function boot() :void
    {
    }

}

