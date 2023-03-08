<?php


namespace App\Http\Requests;

use App\Rules\CarrierExists;
use Illuminate\Foundation\Http\FormRequest;

class LabelCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'shipment_id' => ['required'],
            'carrier_id' => ['required', new CarrierExists],
        ];
    }
}
