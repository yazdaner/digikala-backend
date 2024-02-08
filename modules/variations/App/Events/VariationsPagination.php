<?php

namespace Modules\variations\App\Events;

use Modules\variations\App\Models\Variation;

class VariationsPagination
{
    public function handle($data)
    {
        $onlyTrashed = false;
        if (isset($data['trashed'])) {
            $onlyTrashed = true;
        }
        unset($data['trashed']);
        $variations = Variation::where($data)
            ->with(['param1', 'param2']);
        if ($onlyTrashed) {
            $variations->onlyTrashed();
        }
        $variations = runEvent('variations:select-query', $variations, true);
        return $variations->paginate(env('PAGINATE'));
    }
}
