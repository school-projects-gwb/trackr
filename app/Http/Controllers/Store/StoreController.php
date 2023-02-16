<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function overview()
    {
        $stores = Webstore::where('owner_id', Auth::id())->get();
        return view('store.stores.overview', compact('stores'));
    }

    public function create()
    {
        return view('store.stores.create');
    }

    public function edit(Webstore $store)
    {
        $this->validateStore($store);

        return view('store.stores.edit', compact('store'));
    }

    public function update(Request $request, Webstore $store)
    {
        $this->validateStore($store);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $store->update($validated);

        return to_route('store.stores.overview');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $webStore = Webstore::create([
           'name' => $request->name,
           'owner_id' => Auth::id()
        ]);

        $webStore->users()->attach(Auth::user());

        event(new Registered($webStore));

        return to_route('store.stores.overview');
    }

    private function validateStore(Webstore $store) {
        if (Gate::denies('validate-store', $store)) {
            return abort(403, "Je hebt geen toegang tot deze winkel.");
        }
    }
}
