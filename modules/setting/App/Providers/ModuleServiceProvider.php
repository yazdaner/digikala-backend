<?php
namespace Modules\setting\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\setting\App\Events\SettingValue;
use Modules\setting\App\Events\UpdateOrCreate;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/setting/database/migrations'));
        addEvent('setting:update-create',UpdateOrCreate::class);
        addEvent('setting:value',SettingValue::class);
    }

    public function boot() :void
    {
    }

}

