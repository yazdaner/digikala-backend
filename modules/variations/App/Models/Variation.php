<?php

namespace Modules\variations\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use SoftDeletes;

    protected $table = 'products__variations';
    protected $guarded = [];

    public function param1()
    {
        return $this->morphTo();
    }

    public function param2()
    {
        return $this->morphTo();
    }
}
