<?php

namespace Modules\cart\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\cart\App\Events\ReturnProductsByOrderId;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/cart/database/migrations'));
        require_once base_path('modules/cart/helpers.php');
        addEvent('order:products', ReturnProductsByOrderId::class);
    }

    public function boot(): void
    {
        addArrayList('order-statuses', [
            'title' => 'در انتظار پرداخت',
            'value' => 0,
        ]);
        addArrayList('order-statuses', [
            'title' => 'تایید شده',
            'value' => 5,
        ]);
        addArrayList('order-statuses', [
            'title' => 'آماده سازی سفارش',
            'value' => 10,
        ]);
        addArrayList('order-statuses', [
            'title' => 'خروج از مرکز پردازش',
            'value' => 15,
        ]);
        addArrayList('order-statuses', [
            'title' => 'تحویل به پست',
            'value' => 20,
        ]);
        addArrayList('order-statuses', [
            'title' => 'تحویل مرسوله به مشتری',
            'value' => 25,
        ]);
    }
}
