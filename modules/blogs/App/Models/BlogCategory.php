<?php

namespace Modules\blogs\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\blogs\database\factories\BlogCategoryFactory;

class BlogCategory extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'blog__categories';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function newFactory()
    {
        return BlogCategoryFactory::new();
    }

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
