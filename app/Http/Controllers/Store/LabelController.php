<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    public function createForm(Request $request) {
        if ($request->input('action') == 'label') {
            $shipments = $this->getShipments($request->shipment_id);
            $carriers = Carrier::all();
            $shipmentIds = $request->shipment_id;

            return view('store.labels.createForm', compact('shipments', 'carriers', 'shipmentIds'));
        } else if ($request->input('action') == 'print') {
            dd("HI");
        } else {
            return to_route('store.shipments.overview');
        }
    }

    public function store(LabelCreateRequest $request)
    {
        $request->validated();
        $carrier = Carrier::find($request->carrier_id);

        $shipments = $this->getShipments($request->shipment_id);
        foreach($shipments as $shipment) {
            // Update shipment
            $shipment->carrier()->associate($carrier);
            $shipment->tracking_number = 'TRACKR' . $shipment->id . $carrier->name;
            $shipment->save();

            // Update shipment status
            ShipmentStatus::create([
                'status' => \App\Enums\ShipmentStatusEnum::fromValue('printed'),
                'shipment_id' => $shipment->id
            ]);
        }

        return to_route('store.labels.overview');
    }

    private function getShipments($ids) {
        return Shipment::whereIn('id', array_values($ids))->get();
    }
}
