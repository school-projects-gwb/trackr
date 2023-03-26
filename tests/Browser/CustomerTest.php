<?php

namespace Tests\Browser;

use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests all Customer functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class CustomerTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure logged in customer can save shipment
     * and gets redirected to overview page on dashboard
     * @return void
     * @throws \Throwable
     */
    public function testCanSaveShipment(): void
    {
        $this->browse(function (Browser $browser) {
            $trackingId = Shipment::whereNotNull('tracking_number')
                ->orderBy('id')
                ->value('tracking_number');

            $postalCode = '5555 CW';

            $browser->loginAs(5)
                ->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->press('save-shipment')
                ->assertPathIs('/customer/tracking/overview');

            $this->assertDatabaseHas('user_shipment', [
                'user_id' => '5'
            ]);
        });
    }

    /**
     * Make sure logged in customer can remove saved shipment
     * and gets redirected to overview page on dashboard
     * @return void
     * @throws \Throwable
     */
    public function testCanRemoveSavedShipment(): void
    {
        $this->browse(function (Browser $browser) {
            $trackingId = Shipment::whereNotNull('tracking_number')
                ->orderBy('id')
                ->value('tracking_number');

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
            ]);
        });
    }

    /**
     * Make sure user can review Delivered shipment
     * @return void
     * @throws \Throwable
     */
    public function testCanReviewShipment(): void
    {
        $shipment = Shipment::create([
            'weight' => '2',
            'address_id' => 2,
            'webstore_id' => 1,
            'carrier_id' => 1,
            'tracking_number' => 'REVIEWABLE'
        ]);

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
