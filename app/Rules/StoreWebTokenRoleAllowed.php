<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

class StoreWebTokenRoleAllowed implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $allowedRoles = Role::where('guard_name', 'api');
        $selectedRole = $allowedRoles->where('id', $value)->first();

        return !!$selectedRole;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Deze rol mag niet worden toegepast op een API token.';
    }
}
