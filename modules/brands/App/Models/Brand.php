<?php

namespace Modules\brands\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\brands\database\factories\BrandFactory;

class Brand extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'products__brands';
    protected $guarded = [];

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    public static function search($data)
    {
        $brands = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $brands = $brands->onlyTrashed();
        }
        if(array_key_exists('name',$data) && !empty($data['name']))
        {
            $brands = $brands->where('name','like','%'.$data['name'].'%');
        }
        return $brands->paginate(10);
    }
}


