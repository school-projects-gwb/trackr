<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Http\Request;

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

    public function notfound()
    {
        return view('customer.tracking.not-found');
    }
}
