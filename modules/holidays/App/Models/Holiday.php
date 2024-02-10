<?php

namespace Modules\holidays\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\holidays\database\factories\HolidayFactory;

class Holiday extends Model
{
    use HasFactory;

    protected $table = 'holidays';
    protected $guarded = [];

    protected static function newFactory()
    {
        return HolidayFactory::new();
    }
}


