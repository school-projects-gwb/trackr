<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreTokenRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Webstore;
use App\Models\WebstoreToken;
use http\Env\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Models\Role;

class StoreController extends Controller
{
    private string $defaultSortField = 'name';
    private array $sortableFields = ['name', 'created_at', 'updated_at'];

    public function overview()
    {
        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;

        $stores = Webstore::where('owner_id', Auth::id())
            ->orderBy($sortField, $sortDirection)
            ->paginate(15);

        return view(
            'store.stores.overview',
            compact('stores', 'sortField', 'sortDirection', 'sortableFields'));
    }

    public function create()
    {
        return view('store.stores.create');
    }

    public function edit(Webstore $store)
    {
        $roles = Role::where('guard_name', 'api')->get();
        $webstoreTokens = WebstoreToken::where('webstore_id', $store->id)->get();
        return view('store.stores.edit', compact('store', 'webstoreTokens', 'roles'));
    }

    public function update(StoreUpdateRequest $request, Webstore $store)
    {
        $validated = $request->validated();
        $store->update($validated);

        return to_route('store.stores.overview');
    }

    public function updateAddress(AddressUpdateRequest $request, Webstore $store)
    {
        $validated = $request->validated();
        $store->address->update($validated);

        return to_route('store.stores.overview');
    }

    public function store(StoreCreateRequest $request)
    {
        $request->validated();
        $user = Auth::user();

        $address = new Address;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->street_name = $request->street_name;
        $address->house_number = $request->house_number;
        $address->postal_code = $request->postal_code;
        $address->city = $request->city;
        $address->country = $request->country;
        $address->save();

        $webStore = new Webstore;
        $webStore->name = $request->name;
        $webStore->owner_id = $user->id;
        $webStore->address()->associate($address);
        $webStore->save();
        $webStore->users()->attach($user);

        event(new Registered($webStore));

        return to_route('store.stores.overview');
    }

    public function storeToken(StoreTokenRequest $request){
        $requestData = $request->validated();
        $newToken = bin2hex(random_bytes(32));
        $webstoreToken = new WebstoreToken();
        $webstoreToken->token = Hash::make($newToken);
        $webstoreToken->webstore_id = $requestData['store_id'];
        $webstoreToken->save();
        $webstoreToken->assignRole($requestData['role_id']);
        return redirect()->back()->with([
            'storeSuccess' => true,
            'tokenString' => $newToken,
            'tokenId' => $webstoreToken->id,
            'tokenRole' => $webstoreToken->roles->first()->name,
            ]);
    }

    public function deleteToken(WebstoreToken $webstoreToken){
        $webstoreToken->delete();
        return redirect()->back();
    }

    public function switch(Request $request, Webstore $store) {
        $response = new \Illuminate\Http\Response('Store switched successfully.');
        $cookie = Cookie::forever('selected_store_id', $store->id);
        $response->withCookie($cookie);
        return redirect()->back()->with(['success' => true])->withCookie($cookie);
    }
}
