<?php

namespace Modules\categories\App\Http\Actions;

use Illuminate\Support\Facades\DB;

class AddSpecification
{
    public function __invoke($category_id, $data)
    {
        $technicalSpecifications = $data['technicalSpecifications'];
        $position = 0;
        foreach ($technicalSpecifications as $value) {
            if (!empty($value['name'])) {
                if (array_key_exists('id', $value)) {
                    DB::table('specifications')
                        ->where('id', $value['id'])
                        ->update([
                            'position' => $position,
                            'name' => $value['name'],
                            'important' => (array_key_exists('important', $value) && $value['important'] == 'true'),
                        ]);
                    $id = $value['id'];
                } else {
                    $id = DB::table('specifications')
                        ->insertGetId([
                            'position' => $position,
                            'name' => $value['name'],
                            'important' => (array_key_exists('important', $value) && $value['important'] == 'true'),
                            'category_id' => $category_id,
                            'parent_id' => 0,
                        ]);
                }
                $this->addChilds(
                    $id,
                    $value['childs'],
                    $category_id
                );
                $position++;
            }
        }
    }
    protected function addChilds($parent_id, $childs, $category_id)
    {
        $position = 0;
        foreach ($childs as $child) {
            if (!empty($child['name'])) {
                if (array_key_exists('id', $child)) {
                    DB::table('specifications')
                        ->where('id', $child['id'])
                        ->update([
                            'position' => $position,
                            'name' => $child['name'],
                            'important' => (array_key_exists('important', $child) && $child['important'] == 'true'),
                            'parent_id' => $parent_id,
                        ]);
                } else {
                    DB::table('specifications')
                        ->insert([
                            'position' => $position,
                            'name' => $child['name'],
                            'important' => (array_key_exists('important', $child) && $child['important'] == 'true'),
                            'category_id' => $category_id,
                            'parent_id' => $parent_id,
                        ]);
                }
                $position++;
            }
        }
    }
}
