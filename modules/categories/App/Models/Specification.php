<?php

namespace Modules\categories\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\categories\database\factories\SpecificationFactory;

class Specification extends Model
{
    use HasFactory;
    protected $table = 'specifications';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    protected static function newFactory()
    {
        return SpecificationFactory::new();
    }
}
