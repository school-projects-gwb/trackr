<?php

namespace App\Http\Requests;

use App\Rules\StoreWebTokenRoleAllowed;
use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
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
            'store_id' => ['required', 'integer'],
            'role_id' => ['required', new StoreWebTokenRoleAllowed]
        ];
    }
}
