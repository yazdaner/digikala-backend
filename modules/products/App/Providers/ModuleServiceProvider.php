<?php

namespace Modules\products\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\products\App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Modules\products\App\Events\ProductInfo;
use Modules\products\App\Events\ProductQuery;
use Modules\products\App\Events\SavingProduct;
use Modules\products\App\Events\AddProductGallery;
use Modules\products\App\Events\ProductsIdBasedTag;
use Modules\products\App\Events\ProductsIdBasedCategory;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/products/database/migrations'));
        addEvent('product:created', SavingProduct::class);
        addEvent('product.updated', SavingProduct::class);

        addEvent('product:created', AddProductGallery::class);
        addEvent('product.updated', AddProductGallery::class);

        addEvent('product:query', ProductQuery::class);
        addEvent('product:info', ProductInfo::class);
        addEvent('product:id-based-tag', ProductsIdBasedTag::class);
    }

    public function boot(): void
    {
        Builder::macro('product', function () {
            return $this->getModel()->belongsTo(
                Product::class,
                'product_id',
                'id'
            );
        });
    }
}
