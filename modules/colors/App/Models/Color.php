<?php

namespace Modules\colors\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\colors\database\factories\ColorFactory;

class Color extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'colors';
    protected $guarded = [];

    protected static function newFactory()
    {
        return ColorFactory::new();
    }

    public static function search($data)
    {
        $colors = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $colors = $colors->onlyTrashed();
        }
        if(array_key_exists('name',$data) && !empty($data['name']))
        {
            $colors = $colors->where('name','like','%'.$data['name'].'%');
        }
        return $colors->paginate(10);
    }
}


