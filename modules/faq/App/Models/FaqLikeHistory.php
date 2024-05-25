<?php

namespace Modules\faq\App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqLikeHistory extends Model
{
    protected $table = 'faq__like_history';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','user_id'];
}
