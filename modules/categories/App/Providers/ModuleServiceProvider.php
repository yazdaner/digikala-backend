<?php

namespace Modules\categories\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\categories\App\Events\CategoryQuery;
use Modules\categories\App\Events\SavingProduct;
use Modules\categories\App\Events\AddProductSpecification;
use Modules\categories\App\Models\Category;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        require_once base_path('modules/categories/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/categories/database/migrations'));
        addEvent('product.created', AddProductSpecification::class);
        addEvent('product.updated', AddProductSpecification::class);

        addEvent('product.created', SavingProduct::class);
        addEvent('product.updated', SavingProduct::class);

        addEvent('category:query', CategoryQuery::class);
    }

    public function boot(): void
    {
        Builder::macro('category', function () {
            return $this->getModel()->hasOne(
                Category::class,
                'id',
                'category_id'
            )->withDefault(['name' => '']);
        });
    }
}
