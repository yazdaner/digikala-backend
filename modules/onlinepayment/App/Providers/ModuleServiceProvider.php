<?php
namespace Modules\onlinepayment\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\onlinepayment\App\Events\FindPayment;
use Modules\onlinepayment\App\Events\RequestPayment;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/onlinepayment/database/migrations'));
        addEvent('request-payment',RequestPayment::class);
        addEvent('online-payment:find',FindPayment::class);
    }

    public function boot() :void
    {
    }

}

