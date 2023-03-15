<?php

namespace Database\Factories;

use App\Enums\ShipmentStatusEnum;
use App\Helpers\TrackingNumberGenerator;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    public function definition()
    {
        return [
            'weight' => $this->faker->numberBetween(1, 100),
            'address_id' => Address::factory(),
            'webstore_id' => 1,
            'carrier_id' => 1,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Shipment $shipment) {
            $registeredStatus = $shipment->shipmentStatuses()
                ->where('status', ShipmentStatusEnum::Registered)
                ->latest()
                ->first();

            $printedStatus = new ShipmentStatus([
                'status' => ShipmentStatusEnum::Printed,
                'created_at' => $registeredStatus ? $registeredStatus->created_at->addSeconds(1) : $this->faker->dateTime(),
            ]);

            $shipment->tracking_number = TrackingNumberGenerator::generate($shipment->id, 'DHL');
            $shipment->ShipmentStatuses()->saveMany([$printedStatus]);
            $shipment->save();
        });
    }
}
