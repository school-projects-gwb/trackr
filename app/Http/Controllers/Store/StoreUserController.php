<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWebstore;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('store.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class]
        ]);

        $user->update($validated);

        return to_route('store.users.overview');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $selectedStoreIds = $request->store_id;
        $validStores = Webstore::where('owner_id', Auth::id())->whereIn('id', $request->store_id)->get();
        if (count($selectedStoreIds) != count($validStores)) {
            // invalid STORES input
        }

        $selectedRoleId = $request->role_id;
        $allowedRoles = $this->getAllowedRoles();
        $selectedRole = $allowedRoles->where('id', $selectedRoleId)->first();

        if (!$selectedRole) {
            // invalid ROLE input
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($selectedRole);

        foreach ($validStores as $store) {
            $store->users()->attach($user);
        }

        event(new Registered($user));

        return to_route('store.users.overview');
    }

    private function getAllowedRoles() {
        return Role::whereIn('name', ['StoreAdmin', 'StorePacker'])->get();
    }
}
