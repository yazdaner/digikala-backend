<?php

namespace Modules\pages\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\pages\App\Models\Page;
use Modules\sliders\App\Http\Requests\PageRequest;
use Modules\core\App\Http\Controllers\CrudController;

class PageController extends CrudController
{
    protected $model = Page::class;

    public function index(Request $request)
    {
        $pages = Page::search($request->all());
        return [
            'pages' => $pages,
            'trashCount' => Page::onlyTrashed()->count(),
        ];
    }

    public function store(PageRequest $request)
    {
        $page = new Page($request->all());
        $page->slug = replaceSpace($request->post('en_title'));
        $page->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Page::findOrFail($id);
    }

    public function update($id,PageRequest $request)
    {
        $page = Page::findOrFail($id);
        $page->slug = replaceSpace($request->post('en_title'));
        $page->update($request->all());
        return ['status' => 'ok'];
    }

    public function find($slug)
    {
        return Page::where('slug',$slug)->firstOrFail();
    }
}
