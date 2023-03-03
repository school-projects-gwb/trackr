<?php

namespace App\Http\Controllers\Store;

use App\Filters\FullTextFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCreateRequest;
use App\Http\Requests\StoreUserUpdateRequest;
use App\Models\User;
use App\Models\Webstore;
use App\Rules\StoresOwnedByAuthUser;
use Illuminate\Validation\Rules\Password;
use App\Rules\StoreUserRoleAllowed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StoreUserController extends Controller
{
    private string $defaultSortField = 'name';
    private array $sortableFields = ['name', 'email'];

    public function overview()
    {
        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;

        $ownerId = Auth::id();
        $users = User::where('id', '<>', $ownerId)
            ->whereHas('stores', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->with('stores');

        $users = FullTextFilter::apply($users, 'name', request('zoektermen'));

        $users = $users->orderBy($sortField, $sortDirection)->paginate(15);

        $filterValues = [];
        $filterValues['zoektermen'] = request('zoektermen');

        return view(
            'store.users.overview',
            compact('users', 'sortField', 'sortDirection', 'sortableFields', 'filterValues'));
    }

    public function create()
    {
        $stores = Webstore::where('owner_id', Auth::id())->get();
        $roles = $this->getAllowedRoles();

        return view('store.users.create', compact('stores', 'roles'));
    }

    public function edit(User $user)
    {
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
            'store_id' => ['required', new StoresOwnedByAuthUser],
            'role_id' => ['required', new StoreUserRoleAllowed]
        ]);

        $user->update($validated);
        $user->stores()->sync($request->store_id);
        $user->syncRoles($request->role_id);

        return to_route('store.users.overview');
    }

    public function store(StoreUserCreateRequest $request)
    {
        $request->validated();

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
        $user->stores()->sync([]);
        $user->delete();

        return to_route('store.users.overview');
    }

    private function getAllowedRoles() {
        return Role::whereIn('name', ['StoreAdmin', 'StorePacker'])->get();
    }
}
