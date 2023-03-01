<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    public function overview()
    {
        return view('store.pickups.overview');
    }

    public function create()
    {
        return view('store.pickups.create');
    }

    public function edit(Shipment $store)
    {

    }

    public function update(Request $request, Shipment $store)
    {

    }

    public function store(Request $request)
    {

    }
}
