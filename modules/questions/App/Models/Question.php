<?php

namespace Modules\questions\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = [];

    public function answers(){
        return $this->hasMany(self::class,'parent_id','id');
    }
    
    public function user_like(){
        return $this->belongsTo(LikeHistory::class,'id','question_id');
    }

    public function user(){
        return $this->morphTo();
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }
    
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
