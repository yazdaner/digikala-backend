<?php

namespace Modules\sellers\App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProduct extends Model
{
    protected $table = 'sellers__products';
    protected $guarded = [];
    protected $dateFormat = 'U';
}
