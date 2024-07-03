<?php

namespace Modules\cart\App\Models;

use Modules\cart\App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'orders__submissions';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderProduct::class, 'submission_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
