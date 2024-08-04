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
        return [
            'address' => ['required', 'string:255'],
            'province_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'plaque' => ['required', 'numeric'],
            'postal_code' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric']
        ];
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
