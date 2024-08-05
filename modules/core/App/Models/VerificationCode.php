<?php

namespace Modules\core\App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $table = 'verification_codes';
    protected $guarded = [];
    protected $dateFormat = 'U';

    public static function boot()
    {
        parent::boot();
        self::creating(function($row){
            self::where([
                'tableable_type' => $row->tableable_type,
                'tableable_id' => $row->tableable_id,
            ])->delete();
        });
    }
}


