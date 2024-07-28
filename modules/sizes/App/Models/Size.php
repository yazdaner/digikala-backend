<?php

namespace Modules\sizes\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\sizes\database\factories\SizeFactory;

class Size extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'sizes';
    protected $guarded = [];

    protected static function newFactory()
    {
        return SizeFactory::new();
    }

    public static function search($data)
    {
        $sizes = self::orderBy('id', 'DESC');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $sizes = $sizes->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $sizes = $sizes->where('name', 'like', '%' . $data['name'] . '%');
        }
        return $sizes->paginate(env('PAGINATE'));
    }

    public static function itemsDetail()
    {
        $sizes = self::all();
        $list = [];
        foreach ($sizes as $size) {
            $list[] = [
                'value' => $size->id,
                'title' => $size->name,
            ];
        }
        return [
            'title' => 'سایز',
            'list' => $list,
            'model' => self::class
        ];
    }
}
