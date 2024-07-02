<?php

namespace Modules\cart\App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'orders__submissions';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderProduct::class,'submission_id','id');
    }

}
