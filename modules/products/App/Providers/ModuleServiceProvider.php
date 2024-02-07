<?php
namespace Modules\products\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\products\App\Events\ProductQuery;
use Modules\products\App\Events\SavingProduct;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/products/database/migrations'));
        addEvent('product.created',SavingProduct::class);
        addEvent('product.updated',SavingProduct::class);

        addEvent('product:query',ProductQuery::class);
    }

    public function boot() :void
    {
    }

}

