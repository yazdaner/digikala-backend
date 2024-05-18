<?php

namespace Modules\onlinepayment\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $table = 'online_payments';
    protected $guarded = [];
    protected $dateFormat = 'U';
}