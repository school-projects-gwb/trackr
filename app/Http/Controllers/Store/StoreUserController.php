<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWebstore;
use App\Models\Webstore;
use App\Rules\StoresInAuthUser;
use App\Rules\StoreUserRoleAllowed;
use App\Rules\UserInStore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class StoreUserController extends Controller
{
    public function overview()
    {
        $ownerId = Auth::id();
        $users = User::where('id', '<>', $ownerId)
            ->whereHas('stores', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->with('stores')->get();

        return view('store.users.overview', compact('users'));
    }

    public function create()
    {
        $stores = Webstore::where('owner_id', Auth::id())->get();
        $roles = $this->getAllowedRoles();

        return view('store.users.create', compact('stores', 'roles'));
    }

    public function edit(User $user)
    {
        $this->validateStoreUser($user);

        $stores = Webstore::where('owner_id', Auth::id())->get();
        $roles = $this->getAllowedRoles();

        // Populate roles with extra column; to check if user is in role
        for ($i = 0; $i < count($roles); $i++) {
            $roles[$i]['user_in_role'] = $user->roles->whereIn('id', $roles[$i]['id'])->first() != null;
        }

        for ($i = 0; $i < count($stores); $i++) {
            $stores[$i]['user_in_store'] = $user->stores->whereIn('id', $stores[$i]['id'])->first() != null;
        }

        return view('store.users.edit', compact('user', 'stores', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->validateStoreUser($user);

        // todo custom unique email validation (can't save employee when keeping the same email address
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'store_id' => ['required', new StoresInAuthUser],
            'role_id' => ['required', new StoreUserRoleAllowed]
        ]);

        $user->update($validated);
        $user->stores()->sync($request->store_id);
        $user->syncRoles($request->role_id);

        return to_route('store.users.overview');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'store_id' => ['required', new StoresInAuthUser],
            'role_id' => ['required', new StoreUserRoleAllowed]
        ]);

        // Create user and assign role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($request->role_id);

        $user->stores()->attach($request->store_id);

        event(new Registered($user));

        return to_route('store.users.overview');
    }

    public function delete(Request $request, User $user) {
        $this->validateStoreUser($user);

        $user->stores()->sync([]); // // todo maybe change relationship to on cascade delete
        $user->delete();

        return to_route('store.users.overview');
    }

    private function getAllowedRoles() {
        return Role::whereIn('name', ['StoreAdmin', 'StorePacker'])->get();
    }

    private function validateStoreUser(User $user) {
        if (Gate::denies('validate-store-user', $user)) {
            return abort(403, "Je hebt geen toegang tot deze gebruiker.");
        }
    }
}
