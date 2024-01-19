<?php

namespace Modules\sliders\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\sliders\App\Models\Slider;
use Modules\sliders\App\Http\Requests\SliderRequest;
use Modules\core\App\Http\Controllers\CrudController;

class SliderController extends CrudController
{

    protected $model = Slider::class;

    public function index(Request $request)
    {
        $sliders = Slider::search($request->all());
        return [
            'sliders' => $sliders,
            'trashCount' => Slider::onlyTrashed()->count(),
        ];
    }

    public function store(SliderRequest $request)
    {
        $slider = new Slider($request->all());
        $image = upload_file($request,'image','slider','desktop');
        $mobile_image = upload_file($request,'image','slider','mobile');
        if($image){
            $slider->image = $image;
        }
        if($mobile_image){
            $slider->mobile_image = $mobile_image;
        }
        $slider->saveOrFail();
        return ['status' => 'ok'];
    }

    public function show($id)
    {
        return Slider::findOrFail($id);
    }

    public function update($id,SliderRequest $request)
    {
        $data = $request->all();
        $slider = Slider::findOrFail($id);
        $image = upload_file($request,'image','slider','desktop');
        $mobile_image = upload_file($request,'image','slider','mobile');
        if($image){
            $slider->image = $image ;
        }
        if($mobile_image){
            $slider->mobile_image = $mobile_image ;
        }
        unset($data['image']);
        unset($data['mobile_image']);
        $slider->update($data);
        return ['status' => 'ok'];

    }

    public function all()
    {
        return Slider::select(['id','name','en_name'])->get();
    }
}


