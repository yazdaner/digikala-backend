<?php

namespace Modules\variations\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Modules\variations\App\Http\Requests\UpdateVariationRequest;
use Modules\variations\App\Imports\UpdateVariation;

class UpdateVariationsController extends Controller
{
    public function __invoke(UpdateVariationRequest $request)
    {
        $file = $request->file('file');
        $fileName = Storage::disk('local')->put('excel', $file);
        DB::beginTransaction();
        try {
            Excel::import(
                new UpdateVariation,
                storage_path('/app/' . $fileName)
            );
            DB::commit();
            Storage::disk('local')->delete($fileName);
            return ['status' => 'ok'];
        } catch (\Exception $ex) {
            DB::rollBack();
            // \Log::info($ex->getMessage());
            // \Log::info($ex->getLine());
            // \Log::info($ex->getLine());
            Storage::disk('local')->delete($fileName);
            return ['status' => 'error'];
        }
    }
}
