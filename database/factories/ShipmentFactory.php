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
        $twoWeeksAgo = now()->subWeeks(2);

        return [
            'weight' => $this->faker->numberBetween(1, 100),
            'address_id' => Address::factory(),
            'webstore_id' => 1,
            'created_at' => $this->faker->dateTimeBetween($twoWeeksAgo, 'now'),
            'updated_at' => $this->faker->dateTime(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Shipment $shipment) {
            // Check if a registered status for this shipment already exists
            $registeredStatus = $shipment->shipmentStatuses()
                ->where('status', ShipmentStatusEnum::Registered)
                ->latest()
                ->first();

            // Only create a new registered status if one doesn't already exist
            if (!$registeredStatus) {
                $registeredStatus = new ShipmentStatus([
                    'status' => ShipmentStatusEnum::Registered,
                    'created_at' => $this->faker->dateTime(),
                ]);

                $shipment->shipmentStatuses()->save($registeredStatus);
            }

            $shouldPrintedStatus = $this->faker->boolean(50);
            if ($shouldPrintedStatus) {
                $printedStatus = new ShipmentStatus([
                    'status' => ShipmentStatusEnum::Printed,
                    'created_at' => $registeredStatus->created_at->addSeconds(1),
                ]);
                $shipment->shipmentStatuses()->save($printedStatus);

                $shipment->tracking_number = TrackingNumberGenerator::generate($shipment->id, 'DHL');
                $shipment->carrier_id = $this->faker->numberBetween(1, 3);
                $shipment->save();
            }
        });
    }
}
