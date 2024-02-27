<?php

namespace Modules\addresses\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\addresses\App\Models\Address;
use Modules\addresses\App\Events\AddressDetail;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/addresses/database/migrations'));
        addEvent('address-detail', AddressDetail::class);
    }

    public function boot(): void
    {
        Builder::macro('address', function () {
            return $this->getModel()->belongsTo(
                Address::class,
                'address_id',
                'id'
            )->withTrashed()->with(['province', 'city']);
        });
    }
}
