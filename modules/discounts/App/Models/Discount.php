<?php

namespace Modules\discounts\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\discounts\database\factories\DiscountFactory;

class Discount extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'discounts';
    protected $guarded = [];

    protected static function newFactory()
    {
        return DiscountFactory::new();
    }

    public static function search($data)
    {
        $discounts = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $discounts = $discounts->onlyTrashed();
        }
        if(array_key_exists('code',$data) && !empty($data['code']))
        {
            $discounts = $discounts->where('code','like','%'.$data['code'].'%');
        }
        return $discounts->paginate(env('PAGINATE'));
    }
}

