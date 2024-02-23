<?php

namespace Modules\variations\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\variations\database\factories\VariationFactory;

class Variation extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products__variations';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'selected_by_box',
    ];

    public function param1()
    {
        return $this->morphTo();
    }

    public function param2()
    {
        return $this->morphTo();
    }

    protected static function newFactory()
    {
        return VariationFactory::new();
    }
}
