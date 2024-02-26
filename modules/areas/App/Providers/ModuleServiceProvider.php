<?php

namespace Modules\areas\App\Providers;

use Modules\areas\App\Models\City;
use Modules\areas\App\Models\Province;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/areas/database/migrations'));
    }

    public function boot(): void
    {
        Builder::macro('city', function () {
            return $this->getModel()->belongsTo(
                City::class,
                'id',
                'city_id'
            );
        });

        Builder::macro('province', function () {
            return $this->getModel()->belongsTo(
                Province::class,
                'id',
                'province_id'
            );
        });
    }
}
