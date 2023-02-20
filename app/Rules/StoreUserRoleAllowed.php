<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

class StoreUserRoleAllowed implements Rule
{
    /**
     * Checks whether given role is allowed to be used.
     * @param string $attribute null
     * @param mixed $value role ID
     * @return bool passing status
     */
    public function passes($attribute, $value)
    {
        $allowedRoles = Role::whereIn('name', ['StoreAdmin', 'StorePacker'])->get();
        $selectedRole = $allowedRoles->where('id', $value)->first();

        return !!$selectedRole;
    }

    public function message()
    {
        return 'Deze rol mag niet voor deze gebruiker worden gebruikt.';
    }
}
