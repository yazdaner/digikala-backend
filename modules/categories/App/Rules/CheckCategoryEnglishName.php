<?php

namespace Modules\categories\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\categories\App\Models\Category;

class CheckCategoryEnglishName implements ValidationRule
{
    protected int|null $categoryId;

    public function __construct($id)
    {
        $this->categoryId = intval($id);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $categories = Category::where('en_name',$value)
        ->select(['id','en_name','parent_id'])
        ->where('id','!=',$this->categoryId)
        ->get();
        $request = request();
        if(sizeof($categories) > 0){
            foreach($categories as $category){
                if($category->parent_id == $request->get('parent_id')){
                    $fail('نام انتخابی برای دسته بندی تکراری می باشد');
                }
            }
        }
    }

}
