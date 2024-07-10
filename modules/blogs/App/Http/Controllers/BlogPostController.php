<?php

namespace Modules\blogs\App\Http\Controllers;

use Modules\blogs\App\Models\BlogPost;
use Modules\core\App\Http\Controllers\CrudController;

class BlogPostController extends CrudController
{
    protected string $model = BlogPost::class;

   
}
