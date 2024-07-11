<?php

namespace Modules\blogs\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\blogs\database\factories\BlogTagFactory;

class BlogTag extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'blog__tags';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'description'
    ];

    protected static function newFactory()
    {
        return BlogTagFactory::new();
    }

    public static function search($data)
    {
        $tags = self::query();
        $tags->orderBy('id', 'DESC');

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $tags->onlyTrashed();
        }
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $tags->where('name', 'like', '%' . $data['name'] . '%');
        }
        $paginator = $tags->paginate(env('PAGINATE'));
        $data = $paginator->makeVisible(['description']);
        $paginator->data = $data;
        return $paginator;
    }
}
