<?php
namespace Modules\variations\App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryVariation extends Model
{
    protected $table = 'categories__variations';
    protected $guarded = [];
    protected $timestamps = false;
}
