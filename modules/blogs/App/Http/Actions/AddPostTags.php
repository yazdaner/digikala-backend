<?php

namespace Modules\blogs\App\Http\Actions;

use Modules\blogs\App\Models\BlogPostTags;

class AddPostTags
{
    public function __invoke($postId,$tags)
    {
        BlogPostTags::where('id',$postId)->delete();
        $tags = explode(',',$tags);
        foreach ($tags as $tag) {
            if(!empty($tag)){
                BlogPostTags::create([
                    'post_id' => $postId,
                    'tag_id' => $tag,
                ]);
            }
        }
    }
}
