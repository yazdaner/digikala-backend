<?php

namespace Modules\blogs\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\blogs\App\Models\BlogCategory;
use Modules\blogs\App\Models\BlogPostTags;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $table = 'blog__posts';
    protected $guarded = [];
    protected $dateFormat = 'U';
    protected $hidden = [
        'updated_at'
    ];
    
    public static function search($data)
    {
        $posts = self::query();
        $posts->orderBy('id', 'DESC')->with('category');

        if (array_key_exists('trashed', $data) && $data['trashed'] == 'true') {
            $posts->onlyTrashed();
        }
        if (array_key_exists('title', $data) && !empty($data['title'])) {
            $posts->where('title', 'like', '%' . $data['title'] . '%');
        }
        return $posts->paginate(env('PAGINATE'));
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->hasManyThrough(BlogTag::class, BlogPostTags::class, 'post_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        if (intval($value) !== $value) {
            return Carbon::parse($value)->timestamp;
        } else {
            return $value;
        }
    }
}
