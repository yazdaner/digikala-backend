<?php

namespace Modules\galleries\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'galleries';
    protected $guarded = [];

}


