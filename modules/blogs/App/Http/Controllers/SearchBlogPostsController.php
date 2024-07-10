<?php

namespace Modules\blogs\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\blogs\App\Models\BlogPost;

class SearchBlogPostsController extends Controller
{

    protected Builder $query;

    public function __invoke(Request $request)
    {
        $this->query = BlogPost::query();
        $this->query->orderBy('id','DESC');
        if($request->has('limit')){
            $this->query->limit($request->get('limit'));
            return $this->query->get();
        }else{
            $paginator = $this->query->paginate(env('PAGINATE'));
            $data = $paginator->makeHidden(['author','content']);
            $paginator->data = $data;
            return $paginator;
        }
    }
}
