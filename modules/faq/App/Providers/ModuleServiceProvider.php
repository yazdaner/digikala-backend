<?php
namespace Modules\faq\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/faq/database/migrations'));
    }

    public function boot() :void
    {
    }

}

