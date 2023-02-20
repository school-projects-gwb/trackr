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

    /**
     * Handle the Shipment "updated" event.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return void
     */
    public function updated(Shipment $shipment)
    {
        //
    }

    /**
     * Handle the Shipment "deleted" event.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return void
     */
    public function deleted(Shipment $shipment)
    {
        //
    }

    /**
     * Handle the Shipment "restored" event.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return void
     */
    public function restored(Shipment $shipment)
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return void
     */
    public function forceDeleted(Shipment $shipment)
    {
        //
    }
}
