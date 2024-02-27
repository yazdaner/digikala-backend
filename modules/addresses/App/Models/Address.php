<?php

namespace Modules\addresses\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'users__addresses';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
