<?php

namespace Modules\expertreview\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/expertreview/database/migrations'));
    }

    public function boot(): void
    {
    }
}
