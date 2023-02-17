<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CeateSipmentRequest;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function create(CeateSipmentRequest $request){
        $requestData = $request->validated();
        foreach ($requestData['data'] as $shipmentData){
           $carrier = Carrier::where('name', $shipmentData['carrier'])->pluck('id');
           $address = Address::where('streetname', $shipmentData['streetname'])->where('housenumber', $shipmentData['housenumber'])->where('postal_code', $shipmentData['postalcode']);
           if(!$address->exists()){
               $address = Address::create([
                  'streetname' => $shipmentData['streetname'],
                  'housenumber' =>  $shipmentData['housenumber'],
                   'postal_code' => $shipmentData['postalcode'],
                   'city' => $shipmentData['streetname'],
                   'country' => $shipmentData['country'],
               ])->id;
           } else {
               $address = $address->first()->id;
           }

           Shipment::create([
               'tracking_number' => Shipment::generateShipmentNumber(),
               'weight' => $shipmentData['weight'],
               'address_id' => $address,
               'carrier_id' => $carrier[0]
           ]);
        }
        return response()->json(['succes' => 'Shipments are created'], 201);
    }
}
