<?php

namespace Modules\variations\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Modules\variations\App\Models\Variation;
use Modules\variations\App\Events\ShowProduct;
use Modules\variations\App\Events\VariationQuery;
use Modules\variations\App\Events\AddProductVariation;
use Modules\variations\App\Events\CheckVariationForBuy;
use Modules\variations\App\Events\VariationsPagination;
use Modules\variations\App\Events\UpdateProductVariation;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/variations/database/migrations'));
        addEvent('variation:add', AddProductVariation::class);
        addEvent('variation:update', UpdateProductVariation::class);
        addEvent('variations:pagination', VariationsPagination::class);
        addEvent('check-variation-for-buy', CheckVariationForBuy::class);
        addEvent('variation:query', VariationQuery::class);
        addEvent('product:after-show', ShowProduct::class);
    }

    public function boot(): void
    {
        Builder::macro('variation', function () {
            $variationRelationForignKey = defined('variationRelationForignKey') ? variationRelationForignKey : 'product_id';
            $variationRelationLocalKey = defined('variationRelationLocalKey') ? variationRelationLocalKey : 'id';
            return $this->getModel()->hasOne(
                Variation::class,
                $variationRelationForignKey,
                $variationRelationLocalKey
            )
                ->orderBy('price2', 'ASC');
        });

        Builder::macro('variations', function () {
            $variationRelationForignKey = defined('variationRelationForignKey') ? variationRelationForignKey : 'product_id';
            $variationRelationLocalKey = defined('variationRelationLocalKey') ? variationRelationLocalKey : 'id';
            return $this->getModel()->hasMany(
                Variation::class,
                $variationRelationForignKey,
                $variationRelationLocalKey
            )
                ->orderBy('price2', 'ASC');
        });
    }
}
