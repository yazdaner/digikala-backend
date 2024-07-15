<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];
        if ($this->has('address')) {
            $rules['address'] = ['required', 'string'];
            $rules['province_id'] = ['required', 'numeric'];
            $rules['city_id'] = ['required', 'numeric'];
            $rules['plaque'] = ['required', 'numeric'];
            $rules['postal_code'] = ['required', 'numeric'];
            $rules['latitude'] = ['required', 'numeric'];
            $rules['longitude'] = ['required', 'numeric'];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'address' => 'آدرس پستی',
            'province_id' => 'استان',
            'city_id' => 'شهر',
            'plaque' => 'پلاک',
            'postal_code' => 'کد پستی',
            'latitude' => 'طول جغرافیایی',
            'longitude' => 'عرض جغرافیایی',
        ];
    }
}
