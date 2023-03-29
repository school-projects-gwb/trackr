<?php

namespace App\Http\Controllers\Admin;

use App\Filters\FullTextFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreOwnerCreateRequest;
use App\Http\Requests\StoreOwnerEditRequest;
use App\Models\User;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    private string $defaultSortField = 'name';
    private array $sortableFields = ['name', 'email'];

    public function overview()
    {
        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;

        $users = User::role('StoreOwner');
        $users = FullTextFilter::apply($users, 'name', request('zoektermen'));
        $users = $users->orderBy($sortField, $sortDirection)->paginate(15);

        $filterValues = [];
        $filterValues['zoektermen'] = request('zoektermen');

        return view('admin.users.overview',
            compact('users', 'sortField', 'sortDirection', 'sortableFields', 'filterValues'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(StoreOwnerEditRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update($validated);

        return to_route('admin.users.overview');
    }

    public function store(StoreOwnerCreateRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('StoreOwner');

        event(new Registered($user));

        return redirect('/admin/users');
    }

    public function delete(User $user) {
        $stores = Webstore::where('owner_id', $user->id)->get();

        foreach ($stores as $store) {
            $store->users()->where('id', '!=', $user->id)->forceDelete();
            $store->delete();
        }

        $user->delete();

        return to_route('admin.users.overview');
    }
}
