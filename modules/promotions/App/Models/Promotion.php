<?php

namespace Modules\promotions\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    protected $table = 'promotions';
    protected $guarded = [];
}
