<?php

namespace Modules\cart\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\cart\App\Models\Submission;
use Modules\cart\App\Models\OrderProduct;
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

    public function items()
    {
        return $this->hasManyThrough(OrderProduct::class,Submission::class,'order_id','submission_id');
    }
}
