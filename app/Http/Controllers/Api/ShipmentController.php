<?php

namespace App\Http\Controllers\Api;

use App\Enums\ShipmentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CeateSipmentRequest;
use App\Http\Requests\Api\UpdateShipmentStatusRequest;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;

class ShipmentController extends Controller
{
    public function create(CeateSipmentRequest $request){
        $requestData = $request->validated();
        foreach ($requestData['data'] as $shipmentData){
           $address = Address::where('street_name', $shipmentData['streetname'])->where('house_number', $shipmentData['housenumber'])->where('postal_code', $shipmentData['postalcode']);
           if(!$address->exists()){
               $address = Address::create([
                  'street_name' => $shipmentData['streetname'],
                  'house_number' =>  $shipmentData['housenumber'],
                   'postal_code' => $shipmentData['postalcode'],
                   'city' => $shipmentData['streetname'],
                   'country' => $shipmentData['country'],
               ])->id;
           } else {
               $address = $address->first()->id;
           }

           Shipment::create([
               'weight' => $shipmentData['weight'],
               'address_id' => $address,
               'webstore_id' => $request->webstore_id,
           ]);
        }
        return response()->json([
            'message' => "Shipments are created",],
            201);
    }

    public function updateStatus(UpdateShipmentStatusRequest $request){
        $requestData = $request->validated();
        if($requestData['shipmentStatus'] == ShipmentStatusEnum::Delivered->value && !ShipmentStatus::where('shipment_id', $requestData['shipmentId'])->where('status', ShipmentStatusEnum::Transit)->exists()) {
            return response()->json([
                'message' => "shipmentStatus could not be updated.",
                'errors' => 'The shipment is not in transit yet.']
                , 400);
        }
        ShipmentStatus::create([
           'status' => $requestData["shipmentStatus"],
           'shipment_id' => $requestData["shipmentId"],
        ]);
        return response()->json([
            'message' => "Shipment is updated",],
            201);
    }
}
