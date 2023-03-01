<?php

namespace App\Http\Requests\Api;

use App\Enums\ShipmentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateShipmentStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipmentId' => ['required', 'integer'],
            'shipmentStatus' => ['required', "unique:shipment_statuses,status,{$this->shipmentId}", new Enum(ShipmentStatusEnum::class)]
        ];
    }
}
