<?php

namespace Tests\Browser;

use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomerTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCanSaveShipment(): void
    {
        $this->browse(function (Browser $browser) {
            $trackingId = 'TRACKR1DH';
            $postalCode = '5555 CW';

            $browser->loginAs(5)
                ->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->press('save-shipment')
                ->assertPathIs('/customer/tracking/overview');

            $this->assertDatabaseHas('user_shipment', [
                'user_id' => '5',
                'shipment_id' => '1'
            ]);
        });
    }

    public function testCanRemoveSavedShipment(): void
    {
        $this->browse(function (Browser $browser) {
            $trackingId = 'TRACKR1DH';
            $postalCode = '5555 CW';

            $browser->loginAs(5)
                ->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->press('save-shipment')
                ->press('delete')
                ->acceptDialog()
                ->assertPathIs('/customer/tracking/overview');

            $this->assertDatabaseMissing('user_shipment', [
                'user_id' => '5',
                'shipment_id' => '1'
            ]);
        });
    }

    public function testCanReviewShipment(): void
    {
        $shipment = Shipment::create([
            'weight' => '2',
            'address_id' => 2,
            'webstore_id' => 1,
            'carrier_id' => 1,
            'tracking_number' => 'REVIEWABLE'
        ]);

        $shipment->save();

        $registeredStatus = new ShipmentStatus(['status' => 'registered']);
        $printedStatus = new ShipmentStatus(['status' => 'printed']);
        $sortedStatus = new ShipmentStatus(['status' => 'sorting']);
        $transitStatus = new ShipmentStatus(['status' => 'transit']);
        $deliveredStatus = new ShipmentStatus(['status' => 'delivered']);
        $shipment->ShipmentStatuses()->saveMany([
            $printedStatus, $sortedStatus, $transitStatus, $deliveredStatus
        ]);

        $shipment->save();

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertDatabaseHas('shipments', [
            'tracking_number' => 'REVIEWABLE'
            ]);

        $this->browse(function (Browser $browser) {
            $postalCode = '5555 CW';

            $browser->loginAs(5)
                ->visit('/')
                ->type('tracking_id', 'REVIEWABLE')
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->type('rating', '3')
                ->type('comment', 'whatever')
                ->press('submit');

            $this->assertDatabaseHas('shipment_reviews', [
                'rating' => '3',
                'comment' => 'whatever'
            ]);
        });
    }
}
