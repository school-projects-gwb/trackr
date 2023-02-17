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

        // todo add verification

        $s = Shipment::whereHas('address', function($query) use ($postalCode) {
            $query->where('postal_code', $postalCode);
        })->get();

        var_dump($s);

        return view('customer.tracking.overview', [
            'trackingId' => $trackingId,
            'zipCode' => $postalCode,
        ]);
    }

    public function notfound()
    {
        return view('customer.tracking.not-found');
    }
}
