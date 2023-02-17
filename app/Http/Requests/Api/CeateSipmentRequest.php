<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CeateSipmentRequest extends FormRequest
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
            'data' => 'required|array',
            'data.*.weight' => 'required',
            'data.*.streetname' => 'required|string',
            'data.*.housenumber' => 'required|string',
            'data.*.postalcode' => 'required|regex:/^(?:NL-)?(\d{4})\s*([A-Z]{2})$/i',
            'data.*.city' => 'required|string',
            'data.*.country' => 'required|string',
            'data.*.carrier' => 'required|string',
        ];
    }
}
