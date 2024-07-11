<?php

namespace Modules\statistics\App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsSaleStatistic extends Model
{
    protected $guarded = [];
    protected $table = 'statistics__products_sales';
    protected $dateFormat = 'U';
}
