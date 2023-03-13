<?php


namespace App\Rules;


use App\Models\Carrier;
use App\Models\Webstore;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CarrierExists implements Rule
{
    /**
     * Checks whether given user is in a store owned by current Auth user
     * @param string $attribute null
     * @param mixed $value user ID
     * @return bool passing status
     */
    public function passes($attribute, $value)
    {
        $carrier = Carrier::find($value);
        return !!$carrier;
    }

    public function message()
    {
        return __('Postbezorger bestaat niet.');
    }
}
