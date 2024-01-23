<?php

namespace Modules\variations\App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Modules\variations\App\Models\Variation;

class ModuleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/variations/database/migrations'));
    }

    public function boot(): void
    {
        Builder::macro('variation', function () {
            $variationRelationForignKey = defined('variationRelationForignKey') ? variationRelationForignKey : 'product_id';
            $variationRelationLocalKey = defined('variationRelationLocalKey') ? variationRelationLocalKey : 'id';
            return $this->getModel()->hasOne(Variation::class, $variationRelationForignKey, $variationRelationLocalKey)
                ->orderBy('price2', 'ASC');
        });
    }
}
