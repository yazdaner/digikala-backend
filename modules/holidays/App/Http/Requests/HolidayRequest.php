<?php

namespace Modules\holidays\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\holidays\App\Rules\CheckData;

class HolidayRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required',new CheckData],
            'explain' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'date' => 'تاریخ',
            'explain' => 'توضیح',
        ];
    }
}
