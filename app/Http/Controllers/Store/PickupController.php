<?php

namespace App\Http\Controllers\Store;

use App\Filters\ShipmentStatusFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\PickupCreateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Pickup;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\Webstore;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    public function overview(Request $request)
    {
        $pickups = Pickup::where('webstore_id', $request->cookie('selected_store_id'))
            ->orderBy('pickup_moment', 'asc')
            ->with(['shipments', 'carrier', 'webstore' => function($q){
                $q->with('address');
            }])
            ->get();
        return view('store.pickups.overview', compact('pickups'));
    }

    public function create(Request $request)
    {
        $carriers = Carrier::all();
        $shipments = Shipment::where(['webstore_id' => $request->cookie('selected_store_id'), 'pickup_id' => null])
            ->with(['ShipmentStatuses' => function($q){
                $q->orderBy('created_at', 'desc');
            }])->get()
            ->filter(function ($shipment){
                return $shipment->ShipmentStatuses->first()->status->value == 'printed';
            });
        return view('store.pickups.create', compact('shipments', 'carriers'));
    }

    public function store(PickupCreateRequest $request)
    {
        $shipmentIds = $request->input('shipment_id', []);
        $pickup = Pickup::create([
            'pickup_moment' => $request->input('pickup_datetime'),
            'carrier_id' => $request->input('carrier'),
            'webstore_id' => $request->cookie('selected_store_id')
        ]);

        Shipment::whereIn('id', $shipmentIds)->update([
            'pickup_id' => $pickup->id
        ]);
        return to_route('store.pickups.overview');
    }
}
