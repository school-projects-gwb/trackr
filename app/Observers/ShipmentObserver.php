<?php

namespace App\Observers;

use App\Enums\ShipmentStatusEnum;
use App\Models\Shipment;
use App\Models\ShipmentStatus;

class ShipmentObserver
{
    /**
     * Handle the Shipment "created" event.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return void
     */
    public function created(Shipment $shipment)
    {
        ShipmentStatus::create([
            'status' => ShipmentStatusEnum::Registered,
            'shipment_id' => $shipment->id
        ]);
    }
}
