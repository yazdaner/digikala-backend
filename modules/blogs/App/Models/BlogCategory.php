<?php

namespace Modules\blogs\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    protected $table = 'blog__categories';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public static function search($data)
    {
        $categories = self::query();
        $categories->orderBy('id', 'DESC')->with('parent');

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $categories->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $categories->where('name', 'like', '%' . $data['name'] . '%');
        }
        return $categories->paginate(env('PAGINATE'));
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
