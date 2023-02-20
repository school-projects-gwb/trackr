<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CeateSipmentRequest;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Shipment;
use App\Models\Webstore;
use Illuminate\Http\Request;

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
        return response()->json(['succes' => 'Shipments are created'], 201);
    }
}
