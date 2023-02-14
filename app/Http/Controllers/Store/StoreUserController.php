<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWebstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StoreUserController extends Controller
{
    public function overview()
    {
        $ownerId = Auth::id();
        $users = User::whereHas('stores', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->get();

        return view('store.users.overview', compact('users'));
    }

    public function create()
    {
        return view('store.users.create');
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

        $currentUserId = Auth::id();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return to_route('store.users.overview');
    }
}
