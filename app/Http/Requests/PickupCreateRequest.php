<?php

namespace App\Http\Requests;

use App\Rules\CarrierExists;
use App\Rules\DateIsTwoDaysInPast;
use App\Rules\TimeIsBeforeThree;
use Illuminate\Foundation\Http\FormRequest;

class PickupCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipment_id.*' => ['integer'],
            'shipment_id' => ['required', 'array', 'min:1'],
            'pickup_datetime' => ['required', new DateIsTwoDaysInPast, new TimeIsBeforeThree],
            'carrier' => ['required', new CarrierExists],
        ];
    }

    public function messages()
    {
        return [
            'shipment_id.required' => 'Er moet minmaal één verzending geselecteerd worden.',
            'carrier.required' => 'Er moet één verzender geselecteerd zijn.',
            'pickup_datetime.required' => 'Het ophaal moment moet ingevoerd zijn.',
        ];
    }
}
