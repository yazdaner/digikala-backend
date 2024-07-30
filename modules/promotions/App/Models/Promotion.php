<?php

namespace Modules\promotions\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\promotions\database\factories\PromotionFactory;

class Promotion extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'promotions';
    protected $guarded = [];

    protected static function newFactory()
    {
        return PromotionFactory::new();
    }

    public function products()
    {
        return $this->hasMany(PromotionProduct::class, 'promotion_id', 'id');
    }
}
