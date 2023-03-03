<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TrackingController extends Controller
{
    private string $defaultSortField = 'tracking_number';
    private array $sortableFields = ['tracking_number'];

    public function overviewTracking()
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

        $isDelivered = count($remainingStatuses) == 0;
        return view('customer.tracking.overview-tracking', compact('shipment','remainingStatuses', 'isDelivered'));
    }

    public function review(Request $request, Shipment $shipment)
    {
        $request->validate([
            'rating' => ['required', 'int', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:255']
        ]);

        $statuses = $shipment->shipmentStatuses->pluck('status')->toArray();
        $isDelivered = in_array(\App\Enums\ShipmentStatusEnum::Delivered, $statuses);
        $hasReview = $shipment->review->first();

        // Make sure shipment is delivered
        if ($isDelivered && $hasReview == null) {
            $review = new ShipmentReview;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->shipment()->associate($shipment);
            $review->save();
        }

        return redirect()->action('App\Http\Controllers\Customer\TrackingController@overview',
            ['tracking_id' => $shipment->tracking_number, 'postal_code' => $shipment->address->postal_code]);
    }

    public function delete(Request $request, $shipmentId)
    {
        // Make sure shipment is attached to user, and then delete it
        $check = Auth::user()->savedShipments->where('id', $shipmentId)->first();

        if ($check) {
            Auth::user()->savedShipments()->detach($shipmentId);
        }

        return to_route('customer.tracking.overview');
    }

    public function overview()
    {
        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;
        $itemsPerPage = 15;

        $shipments = Auth::user()->savedShipments()
            ->with(['ShipmentStatuses' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy($sortField, $sortDirection);

        $shipments = \App\Filters\ShipmentStatus::apply(request('status'), $shipments, $itemsPerPage);

        $filterValues = [];
        $filterValues['status'] = \App\Filters\ShipmentStatus::values();

        return view('customer.tracking.overview',
            compact('shipments', 'sortField', 'sortDirection', 'sortableFields', 'filterValues'));
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
}
