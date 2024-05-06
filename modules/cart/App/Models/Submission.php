<?php

namespace Modules\cart\App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'orders__submissions';
    protected $guarded = [];
}
