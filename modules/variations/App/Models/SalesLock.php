<?php
namespace Modules\variations\App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLock extends Model
{
    protected $table = 'products__sales_lock';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($row){
            $unlock = app(VariationUnlock::class);
            $unlock($row);
        });
    }
}
