<?php

namespace Modules\warranties\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\warranties\database\factories\WarrantyFactory;

class Warranty extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'products__warranties';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function newFactory()
    {
        return WarrantyFactory::new();
    }

    public static function search($data)
    {
        $warranties = Warranty::orderBy('id','DESC');
        if(array_key_exists('trashed',$data) && $data['trashed'] == 'true')
        {
            $warranties = $warranties->onlyTrashed();
        }
        if(array_key_exists('name',$data) && !empty($data['name']))
        {
            $warranties = $warranties->where('name','like','%'.$data['name'].'%');
        }
        return $warranties->paginate(10);
    }
}


