<?php

namespace Modules\products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsDetail extends Model
{
    use HasFactory;
    protected $table = 'products__details';
    protected $guarded = [];
}


