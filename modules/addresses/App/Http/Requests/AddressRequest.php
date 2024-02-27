<?php

namespace Modules\addresses\App\Http\Requests;

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
            'address' => ['required', 'string'],
            'province_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'plaque' => ['required', 'numeric'],
            'postal_code' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'recipient_name' => ['required', 'string'],
            'recipient_last_name' => ['required', 'string'],
            'recipient_mobile_number' => ['required', 'string'],
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
            'longitude' => 'عرض جغرافیایی',
            'latitude' => 'طول جغرافیایی',
            'recipient_name' => 'نام گیرنده',
            'recipient_last_name' => 'نام خانوادگی گیرنده',
            'recipient_mobile_number' => 'شماره موبایل گیرنده',
        ];
    }
}
