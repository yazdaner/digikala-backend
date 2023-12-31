<?php

namespace Modules\core\App\Http\Controllers;

use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    public function destroy($id)
    {
        $where = ['id',$id];

        try {
            $row = $this->model::where($where)->withTrashed()->firstOrFail();

        } catch () {
            $row = $this->model::where($where)->firstOrFail();
        }

        if($row->deleted_at == null)
        {
            $row->delete();
        }else{
            $row->forceDelete();
        }
    }

    public function restore($id)
    {
        $where = ['id',$id];
        $row = $this->model::where($where)->onlyTrashed()->firstOrFail();
        $row->restore();
        return ['status'=>'ok'];

    }

}
