<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Shipment;
use Carbon\Carbon;
class ShipmentCreationService
{
    public static function createShipments(array $shipmentsData, string $webstoreId) :void{
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
            ->map(fn($item) => [
                'weight' => $item[1]['weight'],
                'address_id' => $item[0]->id,
                'webstore_id' => $webstoreId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        foreach ($shipments as $shipment){
            Shipment::create($shipment);
        }
    }
}
