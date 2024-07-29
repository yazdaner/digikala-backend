<?php

namespace Modules\variations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralUpdateVariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       if(empty($this->amount)){
            return [
                'percent' => ['required','numeric']
            ];
       }else{
            return [
                'amount' => ['required','numeric']
            ];
       }
    }

    public function attributes(): array
    {
        return [
            'percent' => 'درصد',
            'amount' => 'مقدار',
        ];
    }
}
