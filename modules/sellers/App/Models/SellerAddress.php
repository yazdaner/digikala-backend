<?php

namespace Modules\sellers\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\sellers\database\factories\SellerAddressFactory;

class SellerAddress extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'sellers__address';
    protected $guarded = [];

    protected static function newFactory()
    {
        return SellerAddressFactory::new();
    }
}
