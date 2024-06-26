<?php

namespace Modules\cart\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    protected $table = 'orders__products';
    protected $guarded = [];
    protected $dateFormat = 'U';
}
