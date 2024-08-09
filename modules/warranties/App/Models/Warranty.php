<?php

namespace Modules\warranties\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\warranties\database\factories\WarrantyFactory;

class Warranty extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'warranties';
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
        $warranties = self::orderBy('id', 'DESC');
        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $warranties = $warranties->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $warranties = $warranties->where('name', 'like', '%' . $data['name'] . '%');
        }
        return $warranties->paginate(env('PAGINATE'));
    }

    public static function itemsDetail()
    {
        $warranties = self::all();
        $list = [];
        foreach ($warranties as $warranty) {
            $list[] = [
                'title' => $warranty->name,
                'value' => $warranty->id
            ];
        }
        return [
            'title' => 'گارانتی',
            'list' => $list,
            'model' => self::class,
        ];
    }
}
