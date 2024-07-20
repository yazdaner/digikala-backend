<?php

namespace Modules\sellers\App\Providers;

use Modules\sellers\App\Models\Seller;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\sellers\App\Events\SellerAccess;
use Modules\sellers\App\Models\SellerProduct;
use Modules\sellers\App\Events\UpdateSellerProducts;
use Modules\sellers\App\Events\AddSellerIdToVariation;
use Modules\sellers\App\Http\Middleware\SellerAuthenticate;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        require_once base_path('modules/sellers/helpers.php');
        $this->loadMigrationsFrom(base_path('modules/sellers/database/migrations'));
        $this->app['router']->aliasMiddleware('auth.seller', SellerAuthenticate::class);
        addEvent('access:admin-check', SellerAccess::class);
        addEvent('product:created', UpdateSellerProducts::class);
        addEvent('variation:creating', AddSellerIdToVariation::class);
    }

    public function boot(): void
    {
        updateAuthConfigs();

        Builder::macro('seller', function () {
            return $this->getModel()->belongsTo(
                Seller::class,
                'seller_id',
                'id'
            )->withDefault([
                'brandName' => config('shop-info.name')
            ])->select(['id', 'brandName', 'logo']);
        });

        Builder::macro('product_seller', function () {
            return $this->getModel()->belongsTo(
                SellerProduct::class,
                'id',
                'seller_id'
            );
        });
    }
}
