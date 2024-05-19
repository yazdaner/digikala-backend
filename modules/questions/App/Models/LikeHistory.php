<?php

namespace Modules\questions\App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeHistory extends Model
{
    protected $table = 'questions__like_history';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','user_id'];
}
