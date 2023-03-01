<?php


namespace App\Rules;


use App\Models\User;
use App\Models\Webstore;
use Illuminate\Support\Facades\Auth;

class StoreInUser
{
    /**
     * Checks whether given user is in a store owned by current Auth user
     * @param string $attribute null
     * @param mixed $value user ID
     * @return bool passing status
     */
    public function passes($attribute, $value)
    {
        $store = Webstore::find($value);

        if (!$store) {
            return false;
        }

        // Check whether user is in a store owned by current auth user
        $store = Auth::user()->stores()->where('id', $value)->first();

        return !!$store;
    }

    public function message()
    {
        return 'Store not in user.';
    }
}
