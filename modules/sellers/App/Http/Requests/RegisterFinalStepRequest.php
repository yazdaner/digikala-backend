<?php

namespace Modules\sellers\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFinalStepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string']
        ];
        if ($this->has('addressInfo')) {
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

    protected function getValidatorInstance()
    {
        $array = ['address', 'province_id', 'city_id', 'plaque', 'postal_code', 'latitude', 'longitude'];
        $addressInfo = $this->get('addressInfo');
        if ($addressInfo) {
            foreach ($array as $value) {
                $this->merge([
                    $value => $addressInfo[$value]
                ]);
            }
        }
        return parent::getValidatorInstance();
    }
}
