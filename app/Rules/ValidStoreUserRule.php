<?php


namespace App\Rules;

use App\Models\User;
use App\Models\Webstore;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidStoreUserRule implements Rule
{
    /**
     * Checks whether given user is in a store owned by current Auth user
     * @param string $attribute null
     * @param mixed $value user ID
     * @return bool passing status
     */
    public function passes($attribute, $value)
    {
        $user = User::find($value);

        if (!$user) {
            return false;
        }

        // Check whether user is in a store owned by current auth user
        $store = Webstore::where('owner_id', Auth::id())->whereHas('users', function ($query) use ($value) {
            $query->where('users.id', $value);
        })->first();

        return !!$store;
    }

    public function message()
    {
        return 'User not in store.';
    }
}
