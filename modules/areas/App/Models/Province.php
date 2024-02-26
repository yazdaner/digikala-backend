<?php

namespace Modules\areas\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\areas\database\factories\ProvinceFactory;

class Province extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'provinces';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory()
    {
        return ProvinceFactory::new();
    }

    public static function search($data)
    {
        $provinces = self::orderBy('id', 'DESC');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $provinces = $provinces->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $provinces = $provinces->where('name', 'like', '%' . $data['name'] . '%');
        }
        return $provinces->paginate(env('PAGINATE'));
    }
}
