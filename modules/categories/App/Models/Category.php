<?php

namespace Modules\categories\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\categories\database\factories\CategoryFactory;

class Category extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'categories';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public static function search($data)
    {
        $categories = Category::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $categories = $categories->onlyTrashed();
        }
        if(array_key_exists('name',$data) && !empty($data['name']))
        {
            $categories = $categories->where('name','like','%'.$data['name'].'%');
        }
        return $categories->paginate(10);
    }
}


