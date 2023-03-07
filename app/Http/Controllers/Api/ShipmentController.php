<?php

namespace App\Http\Controllers\Api;

use App\Enums\ShipmentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CeateSipmentRequest;
use App\Http\Requests\Api\UpdateShipmentStatusRequest;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Filters\ShipmentStatusFilter;
use App\Models\WebstoreToken;
use Carbon\Carbon;

class ShipmentController extends Controller
{
    public function create(CeateSipmentRequest $request){
        try {
            $shipmentsData = $request->validated()['data'];
            $webstoreToken = WebstoreToken::findOrFail($request->webstoreToken_id);

            // retrieve or create addresses in bulk
            $addresses = collect($shipmentsData)
                ->map(fn($shipmentData) => Address::firstOrCreate([
                    'street_name' => $shipmentData['streetname'],
                    'house_number' => $shipmentData['housenumber'],
                    'postal_code' => $shipmentData['postalcode'],
                    'city' => $shipmentData['city'],
                    'country' => $shipmentData['country']
                ]));

            // create all the shipments in bulk
            $shipments = $addresses->zip($shipmentsData)
                ->map(fn($items) => [
                    'weight' => $items[1]['weight'],
                    'address_id' => $items[0]->id,
                    'webstore_id' => $webstoreToken->webstore_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            Shipment::insert($shipments->toArray());

            return response()->json([
                'message' => "Shipments are created"
            ], 201);
        } catch (Exception $e) {
            logger()->error($e);
            return response()->json([
                'message' => "An error occurred while creating shipments"
            ], 500);
        }
    }

    public function updateStatus(UpdateShipmentStatusRequest $request){
        $requestData = $request->validated();
        ShipmentStatus::create([
           'status' => $requestData["shipmentStatus"],
           'shipment_id' => $requestData["shipmentId"],
        ]);
        return response()->json([
            'message' => "Shipment is updated",],
            201);
    }
}
