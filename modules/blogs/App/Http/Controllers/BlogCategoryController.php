<?php

namespace Modules\blogs\App\Http\Controllers;

use Modules\blogs\App\Models\BlogCategory;
use Modules\core\App\Http\Controllers\CrudController;

class BlogCategoryController extends CrudController
{
    protected string $model = BlogCategory::class;

   
}
