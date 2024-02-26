<?php

namespace Modules\areas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    protected $table = 'provinces';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

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
