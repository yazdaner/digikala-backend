<?php

namespace Modules\sellers\App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'sellers';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public static array $statusesList = [
        -3 => 'ثبت نام اولیه',
        -2 => 'تایید شماره موبایل',
        -1 => 'تکمیل اطلاعات',
        0 => 'غیر فعال',
        1 => 'فعال'
    ];
}
