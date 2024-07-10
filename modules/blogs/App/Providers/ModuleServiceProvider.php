<?php

namespace Modules\blogs\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/blogs/database/migrations'));
    }

    public function boot(): void
    {
        //
    }
}
