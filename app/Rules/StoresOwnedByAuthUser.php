<?php


namespace App\Rules;


use App\Models\Webstore;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoresOwnedByAuthUser implements Rule
{
    public function passes($attribute, $value)
    {
        $validStores = Webstore::where('owner_id', Auth::id())->whereIn('id', $value)->get();

        return count($value) == count($validStores);
    }

    public function message()
    {
        return 'Je bent niet de eigenaar van één of meerdere winkels.';
    }
}
