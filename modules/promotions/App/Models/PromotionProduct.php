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
        return $this->belongsTo(Promotion::class,'promotion_id','id');
    }
}
