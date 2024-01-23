<?php
namespace Modules\variations\App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Modules\variations\App\Models\Variation;

class ModuleServiceProvider extends ServiceProvider
{

    public function register() :void
    {
        $this->loadMigrationsFrom(base_path('modules/variations/database/migrations'));
    }

    public function boot() :void
    {
        Builder::macro('variation',function(){
            return $this->getModel()->hasOne(Variation::class,'product_id','id')
            ->orderBy('price2','ASC');
        });
    }

}

