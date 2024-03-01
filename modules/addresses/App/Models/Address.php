<?php

namespace Modules\addresses\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\addresses\database\factories\AddressFactory;

class Address extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'users__addresses';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected static function newFactory()
    {
        return AddressFactory::new();
    }
}
