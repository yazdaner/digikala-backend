<?php

namespace Modules\products\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\products\database\factories\ProductFactory;

class Product extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'products';
    protected $guarded = ['pic'];
    protected $hidden = [
        'content',
        'product_count',
        'lowest_price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public static function search($data)
    {
        $products = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $products = $products->onlyTrashed();
        }
        if(array_key_exists('name',$data) && !empty($data['name']))
        {
            $products = $products->where('name','like','%'.$data['name'].'%');
        }
        return $products->paginate(10);
    }
}


