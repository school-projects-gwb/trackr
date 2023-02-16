<?php


namespace App\Rules;

use App\Models\Webstore;
use Illuminate\Support\Facades\Auth;

class ValidStoreRule
{
    /**
     * Checks whether given store is owned by current Auth user
     * @param string $attribute null
     * @param mixed $value store ID
     * @return bool passing status
     */
    public function passes($attribute, $value)
    {
        $store = Webstore::find($value);

        if (!$store) {
            return false;
        }

        // Check whether store is owned by current auth user
        $found = Webstore::where('owner_id', Auth::id())->where('id', $store->id)->first();

        return !!$found;
    }

    public function message()
    {
        return 'User not in store.';
    }
}
