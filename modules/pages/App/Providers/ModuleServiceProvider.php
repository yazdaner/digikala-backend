<?php

namespace Modules\pages\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/pages/database/migrations'));
    }

    public function boot(): void
    {
    }
}
