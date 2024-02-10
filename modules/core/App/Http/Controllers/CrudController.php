<?php

namespace Modules\core\App\Http\Controllers;

use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    public function destroy($id)
    {
        $where = ['id'=>$id];
        if(method_exists($this->model,'findWhere')){
            $where = array_merge($where,$this->middleware::findWhere());
        }
        try {
            $row = $this->model::where($where)->withTrashed()->firstOrFail();
        } catch (\Exception $exception) {
            $row = $this->model::where($where)->firstOrFail();
        }
        if($row->deleted_at == null)
        {
            $row->delete();
        }else{
            $row->forceDelete();
        }
        return ['status'=>'ok'];
    }

    public function restore($id)
    {
        $where = ['id'=>$id];
        if(method_exists($this->model,'findWhere')){
            $where = array_merge($where,$this->middleware::findWhere());
        }
        $row = $this->model::where($where)->onlyTrashed()->firstOrFail();
        $row->restore();
        return ['status'=>'ok'];

    }

}
