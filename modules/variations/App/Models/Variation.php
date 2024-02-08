<?php

namespace Modules\variations\App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
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
