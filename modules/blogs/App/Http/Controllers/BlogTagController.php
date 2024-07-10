<?php

namespace Modules\blogs\App\Http\Controllers;

use Modules\blogs\App\Models\BlogTag;
use Modules\core\App\Http\Controllers\CrudController;

class BlogTagController extends CrudController
{
    protected string $model = BlogTag::class;

   
}
