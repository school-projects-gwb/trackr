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
use App\Services\ShipmentCreationService;
use Carbon\Carbon;
use Exception;

class ShipmentController extends Controller
{
    public function create(CeateSipmentRequest $request){
        try {
            $shipmentsData = $request->validated()['data'];
            $webstoreToken = WebstoreToken::findOrFail($request->webstoreToken_id);
            ShipmentCreationService::createShipments($shipmentsData, $webstoreToken->webstore_id);
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
