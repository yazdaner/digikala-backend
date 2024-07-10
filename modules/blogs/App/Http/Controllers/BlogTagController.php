<?php

namespace Modules\blogs\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\blogs\App\Models\BlogTag;
use Modules\blogs\App\Http\Requests\TagRequest;
use Modules\core\App\Http\Controllers\CrudController;

class BlogTagController extends CrudController
{
    protected string $model = BlogTag::class;

    public function index(Request $request): array
    {
        $tags = BlogTag::search($request->all());
        return [
            'tags' => $tags,
            'trashCount' => BlogTag::onlyTrashed()->count()
        ];
    }

    public function store(TagRequest $request): array
    {
        $tag = new BlogTag($request->all());
        $tag->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return BlogTag::findOrFail($id);
    }

    public function update($id, TagRequest $request): array
    {
        $tag = BlogTag::findOrFail($id);
        $tag->update($request->all());
        return ['status' => 'ok'];
    }

    public function all()
    {
        return BlogTag::select(['id','name'])->get();
    }
}
