<?php

namespace Tests\Feature\categories;

use Modules\categories\App\Models\Category;
use Modules\categories\App\Models\Specification;
use Tests\TestCase;

class SpecificationTest extends TestCase
{

    public function test_add(): void
    {
        Category::factory()->create(['slug' => 'slugTest']);
        $category = Category::firstOrFail();
        $specifications = [];
        for ($i = 0; $i < 10; $i++) {
            $data = Specification::factory()->make()->toArray();
            $childs = [];
            if ($i % 2 == 0) {
                for ($j = 0; $j < 3; $j++) {
                    $childs[] = Specification::factory()->make()->toArray();
                }
            }
            $data['childs'] = $childs;
            $specifications[] = $data;
        }
        $response = $this->post("api/admin/categories/{$category->id}/specifications", [
            'technicalSpecifications' => $specifications
        ]);
        $response->assertOk();
    }

    public function test_update(): void
    {
        $category = Category::firstOrFail();
        $specifications = Specification::where('category_id', $category->id)
            ->where('parent_id', 0)->with('childs')->get();
        $array = [];
        foreach ($specifications as $specification) {
            $array[]=[
                'id' => $specification->id,
                'name' => $specification->name.'updated',
                'parent_id' => $specification->parent_id,
                'important' => $specification->important,
                'childs' => $specification->childs->toArray()
            ];
        }
        $response = $this->post("api/admin/categories/{$category->id}/specifications", [
            'technicalSpecifications' => $array
        ]);
        $response->assertOk();
    }


    public function test_destroy(): void
    {
        $category = Category::factory()->create([
            'slug' => 'slugTest'
        ]);
        $specification = Specification::factory()->create([
            'category_id' => $category->id,
            'position' => 0,
            'parent_id' => 0,
        ]);
        $response = $this->delete('api/admin/categories/specifications/'.$specification->id);
        $this->assertDatabaseMissing('specifications',[
            'id' => $specification->id,
        ]);
        $response->assertOk();
    }




}
