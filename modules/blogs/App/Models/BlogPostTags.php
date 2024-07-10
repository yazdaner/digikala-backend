<?php

namespace Modules\blogs\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPostTags extends Model
{
    use SoftDeletes;
    
    protected $table = 'blog__post_tags';
    protected $guarded = [];
}
