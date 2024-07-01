<?php

namespace Modules\cart\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $guarded = [];
    protected $dateFormat = 'U';

    public function submissions()
    {
        return $this->hasMany(Submission::class,'order_id','id');
    }
}
