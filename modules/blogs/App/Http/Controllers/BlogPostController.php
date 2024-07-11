<?php

namespace Modules\blogs\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\blogs\App\Models\BlogPost;
use Modules\blogs\App\Http\Actions\AddPostTags;
use Modules\blogs\App\Http\Requests\PostRequest;
use Modules\core\App\Http\Controllers\CrudController;

class BlogPostController extends CrudController
{
    protected string $model = BlogPost::class;

    public function index(Request $request): array
    {
        $posts = BlogPost::search($request->all());
        return [
            'posts' => $posts,
            'trashCount' => BlogPost::onlyTrashed()->count()
        ];
    }

    public function store(PostRequest $request, AddPostTags $addPostTags)
    {
        $tags = $request->get('tags');
        $data = $request->all();
        unset($data['tags']);
        $post = new BlogPost($data);
        $user = $request->user();
        $image = upload_file($request, 'image', 'upload', 'post_');
        if ($image) {
            $post->image = $image;
            create_fit_pic('upload/' . $image, $image, 200, 200);
        }
        $post->slug = replaceSpace($request->get('en_title'));
        $post->author = $user->id;
        $post->saveOrFail();
        $addPostTags(
            $post->id,
            $tags
        );
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return BlogPost::with('tags')->findOrFail($id);
    }

    public function update($id, PostRequest $request, AddPostTags $addPostTags)
    {
        $post = BlogPost::findOrFail($id);
        $data = $request->all();
        $image = upload_file($request, 'image', 'upload', 'post_'.$post->id);
        if ($image) {
            $post->image = $image;
            create_fit_pic('upload/' . $image, $image, 200, 200);
        }
        $post->slug = replaceSpace($request->get('en_title'));
        unset($data['image']);
        $post->update($data);
        $addPostTags(
            $post->id,
            $request->get('tags')
        );
        return ['status' => 'ok'];
    }
}
