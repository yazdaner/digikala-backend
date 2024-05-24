<?php
namespace Modules\zarinpal\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\zarinpal\App\Events\VerifyPayment;
use Modules\zarinpal\App\Events\ConnectZarinpalGateway;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        addEvent('connect-zarinpal-gateway',ConnectZarinpalGateway::class);
        addEvent('verify-payment',VerifyPayment::class);
    }

    public function boot() :void
    {
    }

}

