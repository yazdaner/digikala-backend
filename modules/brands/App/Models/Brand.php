<?php

namespace Modules\brands\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\brands\database\factories\BrandFactory;

class Brand extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'products__brands';
    protected $guarded = [];

    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}


