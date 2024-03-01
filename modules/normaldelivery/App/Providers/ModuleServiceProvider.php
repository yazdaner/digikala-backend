<?php
namespace Modules\normaldelivery\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\normaldelivery\App\Events\NormalSubmission;

class ModuleServiceProvider extends ServiceProvider
{
    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/normaldelivery/database/migrations'));
        addArrayList('shipping-methods',[
            'priority' => 1,
            'name' => 'normal-delivery',
            'title' => 'ارسال عادی',
            'event' => 'normal:send-products',
        ]);
        addEvent('normal:send-products',NormalSubmission::class);
    }

    public function boot() :void
    {
    }

}

