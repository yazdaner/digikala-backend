<?php

namespace Modules\promotions\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\promotions\App\Models\Promotion;

class PromotionProduct extends Model
{
    protected $table = 'promotions__products';
    protected $guarded = [];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            runEvent('variation:query', function ($query) use ($product) {
                $query->where('id', $product->variation_id)
                    ->update([
                        'price1' => $product->original_price,
                        'price2' => $product->original_price,
                        'product_count' => ($product->original_count - $product->used_count),
                    ]);
            });
        });
    }
}
