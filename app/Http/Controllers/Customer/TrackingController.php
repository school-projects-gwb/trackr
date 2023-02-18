<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function overview()
    {
        $trackingId = request('tracking_id');
        $postalCode = request('postal_code');

        $shipment = Shipment::where('tracking_number', $trackingId)->whereHas('address', function($query) use ($postalCode) {
            $query->where('postal_code', $postalCode);
        })->with(['shipmentStatuses' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'carrier'])->first();

        if (!$shipment) {
            return view('customer.tracking.not-found');
        }

        $shipmentStatuses = array_column(\App\Enums\ShipmentStatusEnum::cases(), 'value');
        $existingStatuses = $shipment->shipmentStatuses->pluck('status')->toArray();
        $existingStatuses = array_map(function ($status) {
            return $status->value;
        }, $existingStatuses);

        $remainingStatusValues = array_filter($shipmentStatuses, function ($status) use ($existingStatuses) {
            return !in_array($status, $existingStatuses);
        });

        $remainingStatuses = array_map(function ($value) {
            return \App\Enums\ShipmentStatusEnum::fromValue($value);
        }, $remainingStatusValues);

        return view('customer.tracking.overview', compact('shipment','remainingStatuses'));
    }

    public function delete(Request $request, $shipmentId)
    {
        // Make sure shipment is attached to user, and then delete it
        $check = Auth::user()->savedShipments->where('id', $shipmentId)->first();

        if ($check) {
            Auth::user()->savedShipments()->detach($shipmentId);
        }

        $shipments = $this->getSavedShipments();
        return view('customer.tracking.overview-saved', compact('shipments'));
    }

    public function overviewSaved()
    {
        $shipments = $this->getSavedShipments();
        return view('customer.tracking.overview-saved', compact('shipments'));
    }

    public function save(Request $request) {
        $tracking_number = $request->tracking_id;
        $postal_code = $request->postal_code;

        // Get and validate shipment
        $shipment = Shipment::where('tracking_number', $tracking_number)->whereHas('address', function($query) use ($postal_code) {
            $query->where('postal_code', $postal_code);
        })->first();

        if (!$shipment) {
            return view('customer.tracking.not-found');
        }

        // Validate whether shipment has already been saved
        $savedCheck = $shipment->attachedUsers->first();
        if (!$savedCheck) {
            $shipment->attachedUsers()->attach(Auth::user());
        }

        return redirect()->action('App\Http\Controllers\Customer\TrackingController@overview', ['tracking_id' => $tracking_number, 'postal_code' => $postal_code]);
    }

    public function notfound()
    {
        return view('customer.tracking.not-found');
    }

    private function getSavedShipments() {
        return Auth::user()->savedShipments()->with(['ShipmentStatuses' => function ($query) {
            $query->latest('created_at')->take(1);
        }])->get();
    }
}
