<?php
namespace Modules\categories\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\categories\App\Events\CategoryQuery;
use Modules\categories\App\Events\SavingProduct;
use Modules\categories\App\Events\AddProductSpecification;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/categories/database/migrations'));
        addEvent('product.created',AddProductSpecification::class);
        addEvent('product.updated',AddProductSpecification::class);

        addEvent('product.created',SavingProduct::class);
        addEvent('product.updated',SavingProduct::class);

        addEvent('category:query',CategoryQuery::class);
    }

    public function boot() :void
    {
       require_once base_path('modules/categories/helpers.php');
    }

}

