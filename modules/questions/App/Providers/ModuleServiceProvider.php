<?php

namespace Modules\questions\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/questions/database/migrations'));
    }

    public function boot(): void
    {
        //
    }
}
