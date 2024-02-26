<?php

namespace Modules\areas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $table = 'cities';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
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
