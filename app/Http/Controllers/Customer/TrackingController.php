<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function overview()
    {
        $trackingId = request('tracking_id');
        $postalCode = request('postal_code');

        $shipment = Shipment::where('tracking_number', $trackingId)->whereHas('address', function($query) use ($postalCode) {
            $query->where('postal_code', $postalCode);
        })->first();

        if (!$shipment) {
            return view('customer.tracking.not-found');
        } else {
            return view('customer.tracking.overview', compact('shipment', 'trackingId', 'postalCode'));
        }
    }

    public function notfound()
    {
        return view('customer.tracking.not-found');
    }
}
