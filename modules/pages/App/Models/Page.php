<?php

namespace Modules\pages\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\pages\database\factories\PageFactory;

class Page extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'pages';
    protected $guarded = [];

    protected static function newFactory()
    {
        return PageFactory::new();
    }

    public static function search($data)
    {
        $pages = self::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $pages = $pages->onlyTrashed();
        }
        if(array_key_exists('title',$data) && !empty($data['title']))
        {
            $pages = $pages->where('title','like','%'.$data['title'].'%');
        }
        return $pages->paginate(env('PAGINATE'));
    }
}


