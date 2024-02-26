<?php

namespace Modules\areas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\areas\database\factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'cities';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory()
    {
        return CityFactory::new();
    }

    public static function search($data)
    {
        $cities = self::orderBy('id', 'DESC')
            ->with('province');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $cities = $cities->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $cities = $cities->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (array_key_exists('province_id', $data) && !empty($data['province_id'])) {
            $cities = $cities->where('province_id', intval($data['province_id']));
        }
        return $cities->paginate(env('PAGINATE'));
    }
}
