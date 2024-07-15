<?php

namespace Modules\sellers\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerAddress extends Model
{
    use SoftDeletes;

    protected $table = 'sellers__address';
    protected $guarded = [];
}
